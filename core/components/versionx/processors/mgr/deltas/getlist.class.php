<?php

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

        $typeClass = '\\' . $this->getProperty('type');
        $this->type = new $typeClass($this->modx, $this->versionX);

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
            $this->modx->smarty->assign([
                'name' => $field->get('field'),
                'diff' => $field->get('rendered_diff'),
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
