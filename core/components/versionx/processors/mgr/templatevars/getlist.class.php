<?php

class VersionXTemplateVarsGetlistProcessor extends modObjectGetListProcessor {
    public $classKey = 'vxTemplateVar';
    public $primaryKeyField = 'version_id';
    public $defaultSortField = 'saved';
    public $defaultSortDirection = 'DESC';

    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        /* Filter data */
        $search = $this->getProperty('search', null);
        $tv = $this->getProperty('templatevar', null);
        $category = $this->getProperty('category', null);
        $user = $this->getProperty('user', null);
        $from = $this->getProperty('from', null);
        $until = $this->getProperty('until', null);

        $c->leftJoin('modUser', 'User', 'User.id = vxTemplateVar.user');
        $c->leftJoin('modUserProfile', 'Profile', 'Profile.internalKey = User.id');
        $c->leftJoin('modCategory', 'Category', 'Category.id = vxTemplateVar.category');
        $c->select(array(
            'version_id',
            'content_id',
            'name',
            'saved',
            'mode',
            'marked',
            'vxTemplateVar.category',
            'categoryname' => 'Category.category',
            'User.username'
        ));

        /* Filter */
        if ($search) {
            $c->where(array('name:LIKE' => "%$search%"));
        }
        if ($tv) {
            $c->where(array('content_id' => (int)$tv));
        }
        if ($category) {
            $c->where(array('vxTemplateVar.category' => (int)$category));
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

return 'VersionXTemplateVarsGetlistProcessor';

