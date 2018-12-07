<?php

class VersionXGetVersionsProcessor extends modObjectGetListProcessor {
    public $classKey = '';
    public $primaryKeyField = 'version_id';
    public $defaultSortField = 'saved';
    public $defaultSortDirection = 'DESC';

    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $query = (string)$this->getProperty('query');
        if ($query !== '') {
            $c->where([
                'version_id:LIKE' => "%$query%",
            ]);
        }

        $contentId = (int)$this->getProperty('content_id', 0);
        $c->where([
            'content_id' => $contentId,
        ]);

        $currentId = (int)$this->getProperty('current', 0);
        $c->where([
            'version_id:!=' => $currentId,
        ]);

        return $c;
    }

    public function prepareRow(xPDOObject $object)
    {
        $ta = $object->toArray();
        return [
            'id' => $ta['version_id'],
            'display' => '#'.$ta['version_id'] . ': ' . $this->modx->lexicon('versionx.mode.'.$ta['mode']) . ' at ' . date($this->modx->getOption('manager_date_format') . ' ' . $this->modx->getOption('manager_time_format'), strtotime($ta['saved'])),
        ];
    }
}
return 'VersionXGetVersionsProcessor';