<?php

use modmore\VersionX\VersionX;

class VersionXDeltasGetlistProcessor extends modObjectGetListProcessor {
    public $classKey = 'vxDelta';
    public $primaryKeyField = 'vxDelta.version_id';
    public $defaultSortField = 'vxDelta.time_end';
    public $defaultSortDirection = 'DESC';
    public \modmore\VersionX\VersionX $versionX;
    public \modmore\VersionX\Types\Type $type;

    public function initialize(): bool
    {
        $init = parent::initialize();

        $this->versionX = new VersionX($this->modx);
        if (!in_array($this->getProperty('type'), VersionX::CORE_TYPES)) {
            $this->versionX->loadCustomClasses();
        }

        $typeClass = '\\' . $this->getProperty('type');
        $this->type = new $typeClass($this->versionX);

        $this->modx->getService('smarty', 'smarty.modSmarty', '', [
            'template_dir' => $this->versionX->config['templates_path'],
        ]);

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
        $c->leftJoin('modUserProfile', 'Profile', ['Profile.internalKey = User.id']);

        $c->where([
            'vxDelta.principal' => $this->getProperty('principal'),
            'vxDelta.principal_class' => $this->getProperty('principal_class'),
            'vxDelta.principal_package' => $this->getProperty('principal_package'),
        ]);

        // Search filter
        $query = $this->getProperty('query', '');
        if (!empty($query)) {
            // Allow searching by field name
            $c->where([
                "EXISTS (
                    SELECT DeltaField.field 
                    FROM {$this->modx->getTableName(vxDeltaField::class)} DeltaField
                    WHERE DeltaField.delta = vxDelta.id AND
                    DeltaField.field LIKE '%{$query}%'
                )",
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

        // Editor filter
        $editor = $this->getProperty('editor');
        if (!empty($editor)) {
            $c->where([
                'User.username' => $editor,
            ]);
        }

        $c->select([
            'vxDelta.*',
            'user_id' => 'User.id',
            'User.username',
        ]);

//        $c->prepare();
//        $this->modx->log(1, $c->toSQL());

        return $c;
    }

    public function prepareRow(xPDOObject $object): array
    {
        // TODO: Maybe getting the fields like this isn't the most efficient
        $fields = $this->modx->getCollection(vxDeltaField::class, [
            'delta' => $object->get('id'),
        ]);

        // Sort fields as per the Type::getFieldOrder();
        $order = $this->type->getFieldOrder();
        $sorted = [];
        foreach ($order as $position) {
            foreach ($fields as $field) {
                if ($field->get('field') === $position) {
                    $sorted[] = $field;
                }
            }
        }
        // Merge removing duplicates
        $fields = array_unique(array_merge($sorted, $fields), SORT_REGULAR);

        $row = $object->toArray();

        $diffFile = $this->versionX->config['templates_path'] . 'mgr/diff.tpl';
        if (!file_exists($diffFile)) {
            return [];
        }

        $row['diffs'] = '';
        foreach($fields as $field) {
            // Attempt to get diff from cache
            $key = "{$object->get('principal_package')}"
                . "/{$object->get('principal_class')}"
                . "/{$object->get('principal')}"
                . "/{$object->get('id')}"
                . "/{$field->get('id')}";

            // Use cached render if available
            if (!$renderedDiff = $this->modx->cacheManager->get($key, VersionX::CACHE_OPT)) {
                // Otherwise calculate diff
                $fieldType = $this->type->getFieldClass($field->get('field'));
                $fieldTypeObj = new $fieldType($field->get('after'));
                $renderedDiff = $fieldTypeObj->render($field->get('before'), $field->get('after'));

                // Save in cache
                $this->modx->cacheManager->set($key, $renderedDiff, 7200, VersionX::CACHE_OPT);
            }

            $this->modx->smarty->assign([
                'name' => $field->get('field'),
                'diff' => $renderedDiff,
                'field_id' => $field->get('id'),
                'delta_id' => $field->get('delta'),
                'undo' => $this->modx->lexicon('versionx.undo'),
            ]);
            $row['diffs'] .= $this->modx->smarty->fetch($diffFile);
        }

        return $row;
    }
}

return VersionXDeltasGetlistProcessor::class;
