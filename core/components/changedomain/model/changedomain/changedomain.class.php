<?php

class changeDomain
{
    /** @var modX $modx */
    public $modx;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('changedomain_core_path', $config,
            $this->modx->getOption('core_path') . 'components/changedomain/'
        );
        $assetsUrl = $this->modx->getOption('changedomain_assets_url', $config,
            $this->modx->getOption('assets_url') . 'components/changedomain/'
        );
        $connectorUrl = $assetsUrl . 'connector.php';

        $this->config = array_merge(array(
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
            'imagesUrl' => $assetsUrl . 'images/',
            'connectorUrl' => $connectorUrl,

            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'chunksPath' => $corePath . 'elements/chunks/',
            'templatesPath' => $corePath . 'elements/templates/',
            'chunkSuffix' => '.chunk.tpl',
            'snippetsPath' => $corePath . 'elements/snippets/',
            'processorsPath' => $corePath . 'processors/',
        ), $config);

        $this->modx->addPackage('changedomain', $this->config['modelPath']);
        $this->modx->lexicon->load('changedomain:default');
    }

    function loadJsCss(){

        $this->modx->controller->addCss($this->config['cssUrl'] . 'mgr/main.css');
        $this->modx->controller->addCss($this->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
        $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/changedomain.js');
        $this->modx->controller->addLastJavascript($this->config['jsUrl'].'mgr/misc/combo.js');
        $this->modx->controller->addLastJavascript($this->config['jsUrl'].'mgr/misc/utils.js');
        $this->modx->controller->addLastJavascript($this->config['jsUrl'].'mgr/widgets/optionsresource.grid.js');
        $this->modx->controller->addLastJavascript($this->config['jsUrl'].'mgr/resource/tab.js');
        $this->modx->controller->addLastJavascript($this->config['jsUrl'].'mgr/widgets/resource.panel.js');
        $this->modx->controller->addLastJavascript($this->config['jsUrl'].'mgr/widgets/optionsresource.windows.js');

        $this->modx->controller->addHtml('<script type="text/javascript">
            changeDomain.config = ' . json_encode($this->config) . ';
            changeDomain.config.connector_url = "' . $this->config['connectorUrl'] . '";
        </script>
        ');

        $this->modx->controller->addLexiconTopic('changedomain:default');
    }

    public function checkHost($httpHost = ''){

        // Определяем запрашиваемый хост
        $host = stristr($httpHost, '.', true);
        if($host){
            $q = $this->modx->newQuery('changeDomainItem');
            $q->where(array(
                'domain' => $host,
                'active' => 1
            ));
            /**
             * @var xPDOObject $response
             */
            $response = $this->modx->getObject('changeDomainItem', $q);
            if($response){
                $options = $response->getMany('changeDomain', array('domain_id' => $response->get('id')));

                if($options){
                    $opt = array();
                    foreach($options as $option){
                        $opt[] = $option->toArray();
                    }
                }
            }

            if(is_object($response)){
                $output = array(
                    'status' => 'success',
                    'response' => array(
                        'values' => $response->toArray(),
                        'options' => $opt
                    )
                );
            }else{
                $sendRedirectHost = str_replace($host . '.', '', $_SERVER['HTTP_HOST']);
                $output = array(
                    'status' => 'error',
                    'response' => $sendRedirectHost
                );
            }
        }

        return $output;
    }

}