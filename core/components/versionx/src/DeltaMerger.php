<?php

namespace modmore\VersionX;

use Carbon\Carbon;
use modmore\VersionX\Types\Type;
use MODX\Revolution\modX;

class DeltaMerger {
    
    /** @var \modX|modX */
    public $modx;
    public VersionX $versionX;

    private string $fiveYearsAgo;
    private string $eighteenMonthsAgo;
    private string $threeMonthsAgo;
    private string $oneMonthAgo;
    private string $oneWeekAgo;

    protected array $epochs = [];

    function __construct(VersionX $versionX)
    {
        $this->versionX = $versionX;
        $this->modx = $versionX->modx;

        $this->fiveYearsAgo = Carbon::now()->subYears(5)->toDateTimeString();
        $this->eighteenMonthsAgo = Carbon::now()->subMonths(18)->toDateTimeString();
        $this->threeMonthsAgo = Carbon::now()->subMonths(3)->toDateTimeString();
        $this->oneMonthAgo = Carbon::now()->subMonth()->toDateTimeString();
        $this->oneWeekAgo = Carbon::now()->subWeek()->toDateTimeString();

        // Past epochs in datetime strings
        $this->epochs = [
            // 5 years +
            [
                'after' => null,
                'before' => $this->fiveYearsAgo,
            ],
            // 18 months
            [
                'after' => $this->fiveYearsAgo,
                'before' => $this->eighteenMonthsAgo,
            ],
            // 3 months
            [
                'after' => $this->eighteenMonthsAgo,
                'before' => $this->threeMonthsAgo,
            ],
            // 1 month
            [
                'after' => $this->threeMonthsAgo,
                'before' => $this->oneMonthAgo,
            ],
            // 1 week
            [
                'after' => $this->oneMonthAgo,
                'before' => $this->oneWeekAgo,
            ],
        ];
    }

    public function run()
    {
        // Get all versioned objects
        $objects = $this->getAllVersionedObjects();
        foreach ($objects as $object) {
            // Grab the object Type class
            $class = '\\' . $object->getOption('type_class');
            $type = new $class($this->versionX);

            foreach ($this->epochs as $epoch) {
                $this->mergeEpochDeltas($object, $type, $epoch);
            }
        }


    }

    /**
     * Grabs an array of every existing versioned object
     * @return array
     */
    protected function getAllVersionedObjects(): array
    {
        // Get a list of all objects that have related deltas. i.e. versioned objects
        $c = $this->modx->newQuery(\vxDelta::class);
        $c->select([
            'principal_package',
            'principal_class',
            'principal',
            'type_class',
        ]);
        $c->groupby('principal_package, principal_class, principal, type_class');

        // Get with PDO as we need to group without the id
        $c->prepare();
        $types = [];
        if ($c->stmt && $c->stmt->execute()) {
            $types = $c->stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        // Now iterate through the principals, and get objects for each.
        $objects = [];
        foreach ($types as $type) {
            $c = $this->modx->newQuery($type['principal_class']);
            $c->where([
                'id' => $type['principal'],
            ]);
            $object = $this->modx->getObject($type['principal_class'], $c);
            if ($object instanceof \xPDOObject) {
                $object->setOption('type_class', $type['type_class']);
                $objects[] = $object;
            }
        }

        return $objects;
    }

    protected function mergeEpochDeltas(\xPDOObject $object, Type $type, array $epoch)
    {
        // Get all deltas in the epoch sorted by end_time
        $deltas = $this->getEpochDeltas($object, $type, $epoch);
        if (empty($deltas)) {
            return;
        }

        // Grab the first and last deltas (the delta to keep)
        $firstDelta = array_values($deltas)[0];
        $deltaToKeep = end($deltas);
        $id = $deltaToKeep->get('id');

        // Add the end_time of the first delta as the start_time of the last delta
        $deltaToKeep->set('start_time', $firstDelta->get('end_time'));
        $deltaToKeep->save();


        $deltaToKeepFields = $this->modx->getCollection(\vxDeltaField::class, [
            'delta' => $id,
        ]);
        $firstDeltaFields = $this->modx->getCollection(\vxDeltaField::class, [
            'delta' => $firstDelta->get('id'),
        ]);

        foreach ($deltaToKeepFields as $deltaToKeepField) {
            foreach ($firstDeltaFields as $firstDeltaField) {
                // If we've got a matching first delta field, get the before value
                if ($firstDeltaField->get('field') === $deltaToKeepField->get('field')) {
                    $deltaToKeepField->set('before', $firstDeltaField->get('before'));
                    $deltaToKeepField->save();
                }
            }
        }


        $deltaToKeepEditors = $this->modx->getCollection(\vxDeltaEditor::class, [
            'delta' => $id,
        ]);
        // Grab list of editor users we already have on the delta to keep.
        $users = [];
        foreach ($deltaToKeepEditors as $deltaToKeepEditor) {
            $users[] = $deltaToKeepEditor->get('user');
        }

        foreach ($deltas as $delta) {
            // Leave the delta we're keeping alone.
            if ($delta->get('id') === $id) {
                continue;
            }

            // Add any editors we don't already have from other deltas within the time period
            $deltaEditors = $this->modx->getCollection(\vxDeltaEditor::class, [
                'delta' => $delta->get('id'),
            ]);
            foreach ($deltaEditors as $deltaEditor) {
                // Ignore users we already have on the delta to keep
                if (in_array($deltaEditor->get('user'), $users)) {
                    continue;
                }

                // Update editors so they relate to the delta to keep
                $deltaEditor->set('delta', $id);
                $deltaEditor->save();
            }

            $this->modx->log(1, print_r($delta->toArray(), true));

            // Remove the now junk delta! (and fields/editors)
            $this->removeDelta($delta);
        }
    }

    /**
     * @param \vxDelta $delta
     * @return void
     */
    protected function removeDelta(\vxDelta $delta)
    {
        $id = $delta->get('id');

        // Remove fields
        $this->modx->removeCollection(\vxDeltaField::class, [
            'delta' => $id,
        ]);

        // Remove editors
        $this->modx->removeCollection(\vxDeltaEditor::class, [
            'delta' => $id,
        ]);

        // Finally remove the delta
        $delta->remove();
    }

    /**
     * @param \xPDOObject $object
     * @param Type $type
     * @param array $epoch
     * @return array|null
     */
    protected function getEpochDeltas(\xPDOObject $object, Type $type, array $epoch): ?array
    {
        $c = $this->modx->newQuery(\vxDelta::class);
        $where = [
            'principal' => $object->get('id'),
            'principal_class' => $type->getClass(),
        ];
        if (!empty($epoch['after'])) {
            $where['time_end:>'] = $epoch['after'];
        }

        if (!empty($epoch['before'])) {
            $where['time_end:<='] = $epoch['before'];
        }
        $c->where($where);

        $c->sortby('vxDelta.time_end', 'asc');

//        $c->prepare();
//        $this->modx->log(1, $c->toSQL());

        return $this->modx->getCollection(\vxDelta::class, $c);
    }
}