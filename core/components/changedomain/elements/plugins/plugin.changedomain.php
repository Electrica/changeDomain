<?php
/** @var modX $modx
 * @var changeDomain $changeDomain
 *
 */


if (!$changeDomain = $modx->getService('changedomain', 'changeDomain', $modx->getOption('changedomain_core_path', null,
        $modx->getOption('core_path') . 'components/changedomain/') . 'model/changedomain/', $scriptProperties)
) {
    return 'Could not load changeDomain class!';
}

switch ($modx->event->name) {

    case 'OnManagerPageBeforeRender':

        $controller->changeDomain = $changeDomain = $modx->getService('changedomain', 'changeDomain', $modx->getOption('changedomain_core_path', null,
                $modx->getOption('core_path') . 'components/changedomain/') . 'model/changedomain/', $scriptProperties);

        $controller->changeDomain->loadJsCss();
        break;


    case 'OnLoadWebDocument':

        // Извлекаем имя хоста из URL
        if($_SERVER['HTTPS']){
            preg_match('@^(?:https://)?([^/]+)@i',$_SERVER['HTTP_HOST'], $matches);
        }else{
            preg_match('@^(?:http://)?([^/]+)@i',$_SERVER['HTTP_HOST'], $matches);
        }

        $host = $matches[1];

        // извлекаем две последние части имени хоста
        preg_match('/[^.]+\.[^.]+$/', $host, $matches);
        $domain = $matches[0];

        if($host != $domain){
            $response = $changeDomain->checkHost($_SERVER['HTTP_HOST'], $modx->resource->get('id'));
            if($response['status'] == 'success'){
                if($_SESSION['domain']){
                    unset($_SESSION['domain']);
                }
                $_SESSION['domain'] = $response['response'];

                //TODO добавить в плейсхолдеры
                foreach ($_SESSION['domain']['value'] as $key => $value){
                    $modx->setPlaceholder($modx->getOption('changedomain_placeholders', null, 'chd') . '_' . $key, $value);
                }


            }elseif($response['status'] == 'error'){
                if($modx->getOption('changedomain_save_log')){
                    $modx->log(MODX_LOG_LEVEL_ERROR, 'Перешли на ' . $_SERVER['HTTP_HOST']);
                }
                if($modx->getOption('changedomain_redirect')){
                    $http = $_SERVER['HTTPS'] ? 'https://' : 'https://';
                    $modx->sendRedirect($http . $domain, array('responseCode' => 'HTTP/1.1 301 Moved Permanently'));
                }
            }
        }else{
            //TODO это основной сайт
        }
        break;

}