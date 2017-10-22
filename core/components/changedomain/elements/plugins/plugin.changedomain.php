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

    case 'OnHandleRequest':

        // Извлекаем имя хоста из URL
        preg_match('@^(?:http://)?([^/]+)@i',
            $_SERVER['HTTP_HOST'], $matches);
        $host = $matches[1];

        // извлекаем две последние части имени хоста
        preg_match('/[^.]+\.[^.]+$/', $host, $matches);
        $domain = $matches[0];

        if($host != $domain){
            $response = $changeDomain->checkHost($_SERVER['HTTP_HOST']);
            if($response['status'] == 'success'){
                if($_SESSION['domain']){
                    unset($_SESSION['domain']);
                }
                $_SESSION['domain'] = $response['response'];
            }elseif($response['status'] == 'error'){
                $modx->sendRedirect('http://' . $domain, array('responseCode' => 'HTTP/1.1 301 Moved Permanently'));
            }
        }else{
            //TODO это основной сайт
        }
        break;

}