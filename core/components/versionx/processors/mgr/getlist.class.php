<?php

class VersionXResourcesGetlistProcessor extends modObjectGetListProcessor {
    public $classKey = 'vxDelta';
    public $primaryKeyField = 'version_id';
    public $defaultSortField = 'saved';
    public $defaultSortDirection = 'DESC';

    public function prepareQueryBeforeCount(xPDOQuery $c): xPDOQuery
    {
        $c->leftJoin('modUser', 'User');
        $c->leftJoin('modUserProfile', 'Profile', 'Profile.internalKey = User.id');
        $c->select([
            'version_id',
            'content_id',
            'saved',
            'mode',
            'marked',
            'title',
            'context_key',
            'class',
            'User.username'
        )];

        return $c;
    }

    public function prepareRow(xPDOObject $object): array
    {
        return $object->toArray('',false,true);
    }
}

return 'VersionXResourcesGetlistProcessor';
