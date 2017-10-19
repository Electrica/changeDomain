<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
}
else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var changeDomain $changeDomain */
$changeDomain = $modx->getService('changedomain', 'changeDomain', $modx->getOption('changedomain_core_path', null,
        $modx->getOption('core_path') . 'components/changedomain/') . 'model/changedomain/'
);
$modx->lexicon->load('changedomain:default');

// handle request
$corePath = $modx->getOption('changedomain_core_path', null, $modx->getOption('core_path') . 'components/changedomain/');
$path = $modx->getOption('processorsPath', $changeDomain->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));