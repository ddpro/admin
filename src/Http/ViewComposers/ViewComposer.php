<?php

namespace DDPro\Admin\Http\ViewComposers;

/**
 * Class ViewComposer
 * @package DDPro\Admin\Http\ViewComposers
 */
abstract class ViewComposer
{
    /**
     * Bower-ized asset helper
     *
     * Returns a properly prefixed asset URL for bower-ized assets.
     *
     * @param string $assetName
     * @return string
     */
    protected function bowerAsset($assetName)
    {
        return $this->asset('bower_components/' . $assetName);
    }

    /**
     * Asset helper
     *
     * Returns a properly prefixed asset URL using the Laravel asset() helper.
     *
     * @param string $assetName
     * @return string
     */
    protected function asset($assetName)
    {
        return asset('packages/ddpro/admin/' . $assetName);
    }
}