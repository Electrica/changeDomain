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
        $response = $changeDomain->checkHost($_SERVER['HTTP_HOST']);
        if($response['status'] == 'success'){
            if($_SESSION['domain']){
                unset($_SESSION['domain']);
            }
            $_SESSION['domain'] = $response['response'];
        }elseif($response['status'] == 'error'){
            $modx->log(MODX_LOG_LEVEL_ERROR, 'Поддомена ' . $response['response'] . ' нет');
            //TODO Сделать редирект на основной
            //$modx->sendRedirect($response['response']);
        }
        break;

}