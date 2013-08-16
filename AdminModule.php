<?php

class AdminModule extends CWebModule
{
    /**
     * The minimum Bootstrap version, configured in main config, compatible with this module
     */
    const MIN_BOOTSTRAP_VERSION = '2.0.2';

    /**
     * @var string the path to this modules published asset directory
     */
    protected $assetsUrl;

    /**
     * @var boolean indicates whether assets should be republished on every request.
     */
    public $forceCopyAssets = false;

    /**
     * @var boolean indicates if the Bootstrap extension is installed and configured in the main config.
     */
    protected $isBootstrapInstalled = false;

    /**
     * @var string the bootstrap version installed and configured in the main config
     */
    protected $bootstrapVersion = null;

    public function preinit()
    {
        $this->checkDependencies();

        Yii::setPathOfAlias('bootstrap', 'protected/modules/admin/library/bootstrap');

        // Reset the front-end's client script because we don't want
        // both front-end styles being applied in this module.
        Yii::app()->clientScript->reset();
    }

    public function init()
    {
        $this->setImport(array(
            'admin.models.*',
            'admin.components.*',
            'admin.library.*',
        ));

        $this->configure(array(
            'components' => array(
                'bootstrap' => array(
                    'class' => 'AdminBootstrap',
                    'forceCopyAssets' => $this->forceCopyAssets
                )
            )
        ));

        $this->registerCoreCss();
        $this->registerBootstrap();
    }

    /**
     * Initializes the Bootstrap component
     */
    protected function registerBootstrap()
    {
        $this->getComponent('bootstrap')->register();
    }

    /**
     * Registers the published admin CSS
     */
    protected function registerCoreCss()
    {
        Yii::app()->clientScript->registerCssFile($this->getAssetsUrl() . '/css/admin.css');
    }

    /**
     * Publishes and returns the URL to the assets folder.
     * @return string the URL
     */
    protected function getAssetsUrl()
    {
        if (!isset($this->assetsUrl))
        {
            $assetsPath = Yii::getPathOfAlias('admin.assets');
            $this->assetsUrl = Yii::app()->assetManager->publish($assetsPath, true, -1, $this->forceCopyAssets);
        }

        return $this->assetsUrl;
    }

    /**
     * Checks if the Bootstrap extension is installed and verifies it is capable
     */
    protected function checkDependencies()
    {
        $this->isBootstrapInstalled = Yii::app()->hasComponent('bootstrap');

        if ($this->isBootstrapInstalled)
        {
            $this->bootstrapVersion = Yii::app()->bootstrap->getVersion();

            if ($this->bootstrapVersion < self::MIN_BOOTSTRAP_VERSION)
                throw new Exception("Please update your Bootstrap extension to at least " . self::MIN_BOOTSTRAP_VERSION);
        }
    }
}