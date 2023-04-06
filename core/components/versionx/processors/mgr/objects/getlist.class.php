<?php

class VersionXObjectsGetlistProcessor extends modObjectGetListProcessor {
    public $classKey = vxDelta::class;
    public $defaultSortField = 'MAX(vxDelta.time_end)';
    public $defaultSortDirection = 'DESC';
    public \modmore\VersionX\VersionX $versionX;

    protected array $nameFieldMap = [];

    public function initialize(): bool
    {
        $init = parent::initialize();
        $this->versionX = new VersionX($this->modx);

        return $init;
    }

    /**
     * @return bool
     */
    public function beforeQuery(): bool
    {
        // Get all the types
        $c = $this->modx->newQuery('vxDelta');
        $c->groupby('type_class');
        $c->select(['type_class']);

        $c->prepare();
        if ($c->stmt && $c->stmt->execute()) {
            while ($row = $c->stmt->fetch(PDO::FETCH_ASSOC)) {
                $type = new $row['type_class']($this->versionX);
                $this->nameFieldMap[$row['type_class']] = [
                    'name_field' => $type->getNameField(),
                    'principal_class' => $type->getClass(),
                    'principal_package' => $type->getPackage(),
                ];
            }
        }

        return true;
    }

    /**
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c): xPDOQuery
    {
        $c->leftJoin('vxDeltaEditor', 'Editor', [
            'Editor.delta = vxDelta.id',
        ]);
        $c->leftJoin('modUser', 'User', [
            'User.id = Editor.user'
        ]);

        // Search filter
        $query = $this->getProperty('query', '');
        if (!empty($query)) {
            foreach ($this->nameFieldMap as $type => $data) {
                $c->leftJoin($data['principal_class'], $data['principal_class'], [
                    $data['principal_class'] . '.id = vxDelta.principal',
                    'vxDelta.principal_class:=' => $data['principal_class'],
                    'vxDelta.principal_package:=' => $data['principal_package'],
                ]);
                $c->where([
                    'OR:vxDelta.type_class:=' => $type,
                    "{$data['principal_class']}.{$data['name_field']}:LIKE" => "%{$query}%",
                ]);
            }
            $c->where([
                'OR:vxDelta.principal:=' => $query,
            ]);
        }

        // Date from filter
        $dateFrom = $this->getProperty('date_from');
        if (!empty($dateFrom)) {
            $c->where([
                'time_start:>=' => $dateFrom,
                'OR:time_end:>=' => $dateFrom,
            ]);
        }

        // Date to filter
        $dateTo = $this->getProperty('date_to');
        if (!empty($dateTo)) {
            $c->where([
                'time_start:<=' => $dateTo,
                'OR:time_end:<=' => $dateTo,
            ]);
        }

        // Object filter
        $object = $this->getProperty('object');
        if (!empty($object)) {
            $c->where([
                'principal_class' => $object,
            ]);
        }

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

        $c->prepare();
        $c->stmt->execute();
        $data['total'] = $c->stmt->rowCount();

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
