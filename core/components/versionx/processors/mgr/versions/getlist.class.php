<?php

class VersionXDeltasGetlistProcessor extends modObjectGetListProcessor {
    public $classKey = 'vxDelta';
    public $primaryKeyField = 'vxDelta.version_id';
    public $defaultSortField = 'vxDelta.time_end';
    public $defaultSortDirection = 'DESC';

//    public function initialize(): bool
//    {
//        $init = parent::initialize();
//
//        return $init;
//    }

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

        $row = $object->toArray();

        foreach($fields as $field) {
            $row[$field->get('field') . '_diff'] = $field->get('rendered_diff');
        }


        //$this->modx->log(1, print_r($row, true));
        return $row;
    }
}

return VersionXDeltasGetlistProcessor::class;
