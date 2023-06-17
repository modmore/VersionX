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
                'group' => 'year',
            ],
            // 18 months
            [
                'after' => $this->fiveYearsAgo,
                'before' => $this->eighteenMonthsAgo,
                'group' => 'month',
            ],
            // 3 months
            [
                'after' => $this->eighteenMonthsAgo,
                'before' => $this->threeMonthsAgo,
                'group' => 'week',
            ],
            // 1 month
            [
                'after' => $this->threeMonthsAgo,
                'before' => $this->oneMonthAgo,
                'group' => 'day',
            ],
            // 1 week
            [
                'after' => $this->oneMonthAgo,
                'before' => $this->oneWeekAgo,
                'group' => 'hour',
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
                $this->groupDeltas($object, $type, $epoch);
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

    /**
     * @param \xPDOObject $object
     * @param Type $type
     * @param array $epoch
     * @return void
     */
    protected function groupDeltas(\xPDOObject $object, Type $type, array $epoch)
    {
        // Get all deltas in the epoch sorted by time_end
        $deltas = $this->getEpochDeltas($object, $type, $epoch);
        if (empty($deltas)) {
            return;
        }

        // Now merge deltas into the group for the current epoch (per hour, day, week, month, year)
        foreach ($deltas as $keyDelta) {
            $this->mergeDeltas($object, $type, $keyDelta, $epoch);
        }
    }

    /**
     * @param \xPDOObject $object
     * @param Type $type
     * @param \vxDelta $keyDelta
     * @param array $epoch
     * @return void
     */
    protected function mergeDeltas(\xPDOObject $object, Type $type, \vxDelta $keyDelta, array $epoch)
    {
        $timeframe = [];
        $date = Carbon::createFromDate($keyDelta->get('time_end'));
        switch ($epoch['group']) {
            case 'year':
                $timeframe = [
                    'after' => $date->copy()->startOfYear()->toDateTimeString(),
                    'before' => $date->copy()->endOfYear()->toDateTimeString(),
                ];
                break;
            case 'month':
                $timeframe = [
                    'after' => $date->copy()->startOfMonth()->toDateTimeString(),
                    'before' => $date->copy()->endOfMonth()->toDateTimeString(),
                ];
                break;
            case 'week':
                $timeframe = [
                    'after' => $date->copy()->startOfWeek()->toDateTimeString(),
                    'before' => $date->copy()->endOfWeek()->toDateTimeString(),
                ];
                break;
            case 'day':
                $timeframe = [
                    'after' => $date->copy()->startOfDay()->toDateTimeString(),
                    'before' => $date->copy()->endOfDay()->toDateTimeString(),
                ];
                break;
            case 'hour':
                $timeframe = [
                    'after' => $date->copy()->startOfHour()->toDateTimeString(),
                    'before' => $date->copy()->endOfHour()->toDateTimeString(),
                ];
                break;
        }

        if (empty($timeframe)) {
            return;
        }

        $deltas = $this->getEpochDeltas($object, $type, $timeframe);
        if (empty($deltas)) {
            return;
        }

        // Grab the first and last deltas (the delta to keep)
        $firstDelta = array_values($deltas)[0];
        $deltaToKeep = end($deltas);

        // Add the time_start of the first delta as the time_start of the last delta
        $deltaToKeep->set('time_start', $firstDelta->get('time_start'));
        $deltaToKeep->save();

        // Merge delta fields for the epoch, and discard the orphans
        $fields = $this->mergeFields($deltas, $deltaToKeep);

        // Collate all editors for the epoch and set them to the last delta. Remove the rest.
        $editors = $this->mergeEditors($deltas, $deltaToKeep);

        // Remove orphaned deltas
        foreach ($deltas as $delta) {
            if ($delta->get('id') !== $deltaToKeep->get('id')) {
                $delta->remove();
            }
        }
    }

    /**
     * @param array $deltas
     * @param \vxDelta $deltaToKeep
     * @return array
     */
    protected function mergeFields(array $deltas, \vxDelta $deltaToKeep): array
    {
        $mergedFields = [];
        $keepIds = [];
        foreach ($deltas as $delta) {
            $fields = $this->modx->getCollection(\vxDeltaField::class, [
                'delta' => $delta->get('id'),
            ]);
            foreach ($fields as $field) {
                $field->set('delta', $deltaToKeep->get('id'));
                $field->save();
                $mergedFields[$field->get('field')] = $field;

                // Add the field id to the list we need to keep
                $keepIds[$field->get('field')] = $field->get('id');
            }

            // Delete fields we're not keeping after taking their 'after' values
            $this->modx->removeCollection(\vxDeltaField::class, [
                'delta:=' => $delta->get('id'),
                'id:NOT IN' => $keepIds,
            ]);
        }

        return $mergedFields;
    }

    /**
     * @param array $deltas
     * @param \vxDelta $deltaToKeep
     * @return array
     */
    protected function mergeEditors(array $deltas, \vxDelta $deltaToKeep): array
    {
        $editors = [];
        $keepIds = [];
        foreach ($deltas as $delta) {
            $deltaEditors = $this->modx->getCollection(\vxDeltaEditor::class, [
                'delta' => $delta->get('id'),
            ]);
            foreach ($deltaEditors as $deltaEditor) {
                if (!isset($editors[$deltaEditor->get('user')])) {
                    $deltaEditor->set('delta', $deltaToKeep->get('id'));
                    $deltaEditor->save();

                    $editors[$deltaEditor->get('user')] = $deltaEditor;
                    $keepIds[$deltaEditor->get('user')] = $deltaEditor->get('id');
                }
            }

            // Delete fields we're not keeping after taking their 'after' values
            $this->modx->removeCollection(\vxDeltaEditor::class, [
                'delta:=' => $delta->get('id'),
                'id:NOT IN' => $keepIds,
            ]);
        }

        return $editors;
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
            'milestone' => '', // Only include deltas without a milestone value
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