<?php

class VersionXObjectsGetlistProcessor extends modObjectGetListProcessor {
    public $classKey = vxDelta::class;
    public $defaultSortField = 'MAX(vxDelta.time_end)';
    public $defaultSortDirection = 'DESC';
    public \modmore\VersionX\VersionX $versionX;

    public function initialize(): bool
    {
        $init = parent::initialize();
        $this->versionX = new VersionX($this->modx);

        return $init;
    }

    public function prepareQueryBeforeCount(xPDOQuery $c): xPDOQuery
    {
        $c->leftJoin('vxDeltaEditor', 'Editor', [
            'Editor.delta = vxDelta.id',
        ]);
        $c->leftJoin('modUser', 'User', [
            'User.id = Editor.user'
        ]);

        $c->groupby('
            vxDelta.principal,
            vxDelta.principal_package,
            vxDelta.principal_class,
            vxDelta.type_class,
            Editor.user,
            User.username
        ');

        $c->select([
            'MAX(vxDelta.id)',
            'vxDelta.principal',
            'vxDelta.principal_package',
            'vxDelta.principal_class',
            'type' => 'vxDelta.type_class',
            'time_start' => 'MAX(vxDelta.time_start)',
            'time_end' => 'MAX(vxDelta.time_end)',
            'user_id' => 'Editor.user',
            'username' => 'User.username',
//            'users' => "GROUP_CONCAT(DISTINCT User.id, ':', User.username separator ',')",
        ]);

        return $c;
    }

    public function getData(): array
    {
        $data = [];
        $limit = (int)$this->getProperty('limit');
        $start = (int)$this->getProperty('start');

        $c = $this->modx->newQuery($this->classKey);
        $c = $this->prepareQueryBeforeCount($c);
        $data['total'] = $this->modx->getCount($this->classKey, $c);
        $c = $this->prepareQueryAfterCount($c);

        $sortClassKey = $this->getSortClassKey();
        $sortAlias = $this->getSortClassKey();
        if (strpos($sortAlias, '\\') !== false) {
            $explodedAlias = explode('\\', $sortAlias);
            $sortAlias = array_pop($explodedAlias);
        }
        $sortKey = $this->modx->getSelectColumns(
            $sortClassKey,
            $this->getProperty('sortAlias', $sortAlias),
            '',
            [$this->getProperty('sort')]
        );
        if (empty($sortKey)) {
            $sortKey = $this->getProperty('sort');
        }
        $c->sortby($sortKey, $this->getProperty('dir'));
        if ($limit > 0) {
            $c->limit($limit, $start);
        }

        // Use PDO so we don't have to worry about the object ids when grouping
        $c->prepare();
        if ($c->stmt && $c->stmt->execute()) {
            $data['results'] = $c->stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
//
//        $c->prepare();
//        $this->modx->log(1, $c->toSQL());

        return $data;
    }

    public function iterate(array $data): array
    {
        $list = [];
        $list = $this->beforeIteration($list);
        $this->currentIndex = 0;
        foreach ($data['results'] as $row) {

            // If the principal object no longer exists (perhaps a snippet was deleted), don't include its deltas
            /** @var xPDOObject $object */
            $object = $this->modx->getObject($row['principal_class'], ['id' => $row['principal']]);
            if (!$object) {
                continue;
            }

            $objectArray = $this->prepareArrayRow($row, $object);
            if (!empty($objectArray)) {
                $list[] = $objectArray;
                $this->currentIndex++;
            }
        }
        return $this->afterIteration($list);
    }

    /**
     * @param array $row
     * @param xPDOObject $object
     * @return array
     */
    public function prepareArrayRow(array $row, xPDOObject $object): array
    {
        $type = new $row['type']($this->versionX);
        $nameField = $type->getNameField();
        $row['name'] = $object->get($nameField);

        return $row;
    }
}

return VersionXObjectsGetlistProcessor::class;
