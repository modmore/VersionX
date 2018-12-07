<?php

class VersionXTemplatesGetlistProcessor extends modObjectGetListProcessor {
    public $classKey = 'vxTemplate';
    public $primaryKeyField = 'version_id';
    public $defaultSortField = 'saved';
    public $defaultSortDirection = 'DESC';

    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        /* Filter data */
        $search = $this->getProperty('search', null);
        $template = $this->getProperty('template', null);
        $category = $this->getProperty('category', null);
        $user = $this->getProperty('user', null);
        $from = $this->getProperty('from', null);
        $until = $this->getProperty('until', null);

        $c->leftJoin('modUser', 'User', 'User.id = vxTemplate.user');
        $c->leftJoin('modUserProfile', 'Profile', 'Profile.internalKey = User.id');
        $c->leftJoin('modCategory', 'Category', 'Category.id = vxTemplate.category');
        $c->select(array(
            'version_id',
            'content_id',
            'saved',
            'mode',
            'marked',
            'templatename',
            'vxTemplate.category',
            'categoryname' => 'Category.category',
            'User.username'
        ));

        /* Filter */
        if ($search) {
            $c->where(array('templatename:LIKE' => "%$search%"));
        }
        if ($template) {
            $c->where(array('content_id' => (int)$template));
        }
        if ($category) {
            $c->where(array('vxTemplate.category' => (int)$category));
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

return 'VersionXTemplatesGetlistProcessor';
