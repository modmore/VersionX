<?php

class VersionXRevertProcessor extends modProcessor {
    public $classKey = '';

    /** @var xPDOObject */
    protected $object;

    /** @var VersionX */
    protected $versionx;

    public function initialize()
    {
        $path = $this->modx->getOption('versionx.core_path', null, MODX_CORE_PATH . 'components/versionx/');
        $this->versionx =& $this->modx->getService('versionx', 'VersionX', $path . 'model/');
        if (!$this->versionx) {
            return 'Could not load VersionX service';
        }

        $contentId = (int)$this->getProperty('content_id');
        $versionId = (int)$this->getProperty('version_id');
        if ($contentId < 1 || $versionId < 1) {
            return 'Content or Version ID not specified.';
        }

        $this->object = $this->modx->getObject($this->classKey, [
            'content_id' => $contentId,
            'version_id' => $versionId
        ]);

        if (!($this->object instanceof xPDOObject)) {
            return 'Object not found.';
        }

        return true;
    }

    public function process()
    {
        if (!$this->object->revert()) {
            return $this->failure('An error occurred while reverting the version.');
        }

        $this->modx->getCacheManager()->refresh();

        $title = $this->object->get('name') ?: $this->object->get('title') ?: $this->object->get('templatename');
        $this->modx->logManagerAction(strtolower($this->classKey) . '_revert', $this->object->get('class'),$title .  ' (Content ID: ' . $this->object->get('content_id') . ' => Version ID: ' . $this->object->get('version_id') . ')');

        $this->versionx->newVersionFor($this->classKey, $this->object->get('content_id'), 'revert');

        return $this->success();
    }
}