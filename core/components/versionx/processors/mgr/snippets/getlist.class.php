<?php

class VersionXSnippetsGetlistProcessor extends modObjectGetListProcessor {
    public $classKey = 'vxSnippet';
    public $primaryKeyField = 'version_id';
    public $defaultSortField = 'saved';
    public $defaultSortDirection = 'DESC';

    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        /* Filter data */
        $object = $this->getProperty('snippet', null);
        $search = $this->getProperty('search', null);
        $category = $this->getProperty('category', null);
        $user = $this->getProperty('user', null);
        $from = $this->getProperty('from', null);
        $until = $this->getProperty('until', null);

        $c->leftJoin('modUser', 'User', 'User.id = vxSnippet.user');
        $c->leftJoin('modUserProfile', 'Profile', 'Profile.internalKey = User.id');
        $c->leftJoin('modCategory', 'Category', 'Category.id = vxSnippet.category');
        $c->select(array(
            'version_id',
            'content_id',
            'saved',
            'mode',
            'marked',
            'name',
            'vxSnippet.category',
            'categoryname' => 'Category.category',
            'User.username'
        ));

        /* Filter */
        if ($search) {
            $c->where(array('name:LIKE' => "%$search%"));
        }
        if ($object) {
            $c->where(array('content_id' => (int)$object));
        }
        if ($category) {
            $c->where(array('vxSnippet.category' => (int)$category));
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

return 'VersionXSnippetsGetlistProcessor';
