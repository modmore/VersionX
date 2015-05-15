<?php
/**
 * Creates a new version for a certain object.
 */
class VersionX_SaveDraftProcessor extends modObjectCreateProcessor {
    /** @var vxBaseObject $object */
    public $object = null;
    public $classKey = 'vxResource';
    public $languageTopics = array('versionx:default');

    /**
     * {@inheritdoc}
     *
     * Dynamically assigns the classKey (defaulting to vxResource) as long as it's a valid type extending vxBaseObject.
     *
     * @return bool
     */
    public function initialize() {
        $type = $this->getProperty('vx_type', 'vxResource');
        $this->unsetProperty('vx_type');
        if (!empty($type) && in_array($type, $this->modx->classMap['vxBaseObject'])) {
            $this->classKey = $type;
        }

        return parent::initialize();
    }

    /**
     * Before setting, we check if the name is filled and/or already exists. Also checkboxes.
     * @return bool
     */
    public function beforeSet() {
        /** Do not use the default fromArray(), but instead let each */
        $properties = $this->getProperties();
        $this->properties = array();
        $this->setProperties($this->object->cleanupProperties($properties));
        foreach ($properties as $key => $value) {
            $this->unsetProperty($key);
        }

        return parent::beforeSet();
    }
}
return 'VersionX_SaveDraftProcessor';
