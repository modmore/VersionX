<?php

class VersionXEditorsFilterProcessor extends modObjectGetListProcessor
{
    public $classKey = vxDeltaEditor::class;
    public $defaultSortField = 'User.username';
    public $defaultSortDirection = 'asc';

    /**
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c): xPDOQuery
    {
        $c->innerJoin(modUser::class, 'User', [
            'vxDeltaEditor.user = User.id',
        ]);

        $c->select([
            'vxDeltaEditor.*',
            'username' => 'User.username',
        ]);

        $query = trim($this->getProperty('query'));

        if ($query) {
            $c->where(['User.username:LIKE' => '%'.$query.'%']);
        }

        $c->groupBy('User.username');

        return $c;
    }

    /**
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object): array
    {
        $name = $object->get('username');
        return [
            'id' => $name,
            'name' => $name,
        ];
    }
}
return 'VersionXEditorsFilterProcessor';
