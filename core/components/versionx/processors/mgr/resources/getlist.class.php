<?php

class VersionXResourcesGetlistProcessor extends modObjectGetListProcessor {
    public $classKey = 'vxResource';
    public $primaryKeyField = 'version_id';
    public $defaultSortField = 'saved';
    public $defaultSortDirection = 'DESC';

    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $c->leftJoin('modUser', 'User');
        $c->leftJoin('modUserProfile', 'Profile', 'Profile.internalKey = User.id');
        $c->select(array(
            'version_id',
            'content_id',
            'saved',
            'mode',
            'marked',
            'title',
            'context_key',
            'class',
            'User.username'
        ));

        /* Filter data */
        $search = $this->getProperty('search', null);
        $resource = $this->getProperty('resource', null);
        $context = $this->getProperty('context', null);
        $class = $this->getProperty('class', null);
        $user = $this->getProperty('user', null);
        $from = $this->getProperty('from', null);
        $until = $this->getProperty('until', null);

        /* Filter */
        if ($search) {
            $c->where(array('title:LIKE' => "%$search%"));
        }
        if ($resource && is_numeric($resource)) {
            $c->where(array('content_id' => (int)$resource));
        }
        if ($context) {
            $c->where(array('context_key' => $context));
        }
        if ($class) {
            $c->where(array('class' => $class));
        }
        if ($user && is_numeric($user)) {
            $c->where(array('user' => (int)$user));
        }
        if ($from) {
            $c->where(array('saved:>' => $from));
        }
        if ($until) {
            $c->where(array('saved:<' => $until));
        }

        return $c;
    }

    public function prepareRow(xPDOObject $object)
    {
        return $object->toArray('',false,true);
    }
}

return 'VersionXResourcesGetlistProcessor';
