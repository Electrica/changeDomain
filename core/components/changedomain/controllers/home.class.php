<?php

/**
 * The home manager controller for changeDomain.
 *
 */
class changeDomainHomeManagerController extends modExtraManagerController
{
    /** @var changeDomain $changeDomain */
    public $changeDomain;


    /**
     *
     */
    public function initialize()
    {
        $path = $this->modx->getOption('changedomain_core_path', null,
                $this->modx->getOption('core_path') . 'components/changedomain/') . 'model/changedomain/';
        $this->changeDomain = $this->modx->getService('changedomain', 'changeDomain', $path);
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return array('changedomain:default');
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('changedomain');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->changeDomain->config['cssUrl'] . 'mgr/main.css');
        $this->addCss($this->changeDomain->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
        $this->addJavascript($this->changeDomain->config['jsUrl'] . 'mgr/changedomain.js');
        $this->addJavascript($this->changeDomain->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->changeDomain->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->changeDomain->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->changeDomain->config['jsUrl'] . 'mgr/widgets/options.grid.js');
        $this->addJavascript($this->changeDomain->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->changeDomain->config['jsUrl'] . 'mgr/widgets/options.windows.js');
        $this->addJavascript($this->changeDomain->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->changeDomain->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        changeDomain.config = ' . json_encode($this->changeDomain->config) . ';
        changeDomain.config.connector_url = "' . $this->changeDomain->config['connectorUrl'] . '";
        Ext.onReady(function() {
            MODx.load({ xtype: "changedomain-page-home"});
        });
        </script>
        ');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->changeDomain->config['templatesPath'] . 'home.tpl';
    }
}