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

    public function checkHost($httpHost = ''){

        // Определяем запрашиваемый хост
        $host = stristr($httpHost, '.', true);
        if($host){
            $q = $this->modx->newQuery('changeDomainItem');
            $q->where(array(
                'domain' => $host,
                'active' => 1
            ));
            $response = $this->modx->getObject('changeDomainItem', $q);
            if(is_object($response)){
                $output = array(
                    'status' => 'success',
                    'response' => $response->toArray()
                );
            }else{
                $sendRedirectHost = str_replace($host . '.', '', $_SERVER['HTTP_HOST']);
                $output = array(
                    'status' => 'error',
                    'response' => $host
                );
            }
        }

        return $output;
    }

}