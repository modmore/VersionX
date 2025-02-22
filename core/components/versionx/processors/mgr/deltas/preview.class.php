<?php

class VersionXRevertPreviewProcessor extends modProcessor
{
    public \modmore\VersionX\VersionX $versionX;
    public ?\MagicPreview $magicPreview = null;

    public function initialize()
    {
        $init = parent::initialize();
        $path = $this->modx->getOption(
            'magicpreview.core_path',
            null,
            $this->modx->getOption('core_path') . 'components/magicpreview/'
        );
        $this->magicPreview ??= $this->modx->getService(
            'magicpreview',
            'MagicPreview',
            $path . '/model/magicpreview/'
        );

        return $init;
    }

    public function process()
    {
        $resource = $this->modx->getObject(modResource::class, ['id' => $this->getProperty('id')]);
        if (!$resource) {
            return $this->failure('Resource not found');
        }

        $properties = array_merge($this->properties, $resource->toArray());
        /** @var modProcessorResponse $response */
        $response = $this->modx->runProcessor('resource/preview', $properties, [
            'processors_path' => $this->magicPreview->config['processorsPath'],
        ]);

        return $this->success('wooo', $response->getResponse()['object']);
    }
}
return 'VersionXRevertPreviewProcessor';