<?php
/**
 * @var modX $modx
 * @var array $scriptProperties
 * @var changeDomain $changeDomain
 */

if(!$changeDomain = $modx->getService('changeDomain', 'changeDomain', $modx->getOption('changedomain_core_path', null, $modx->getOption('core_path') , 'components/changedomain') . 'model/changedomain', $scriptProperties)){
    return 'Could not load changeDomain class';
}

$tpl = $modx->getOption('tpl', $scriptProperties, 'tpl.changeDomain');
$sortby = $modx->getOption('sortby', $scriptProperties, 'name');
$sortdir = $modx->getOption('sortdir', $scriptProperties, 'ASC');
$limit = $modx->getOption('limit', $scriptProperties, '10');
$active = $modx->getOption('active', $scriptProperties, true);


$c = $modx->newQuery('changeDomainItem');
$c->sortby($sortby, $sortdir);
$c->limit($limit);
$c->where(array('active' => $active));

$domains = $modx->getIterator('changeDomainItem', $c);
$pdoTools = $modx->getService('pdoTools');

// Получаем ссылку на сайт с учетом поддомена

$link = $modx->getOption('site_url');

// Извлекаем имя хоста из URL
if(strstr($link, 'https://')){
    preg_match('@^(?:https://)?([^/]+)@i',$link, $matches);
    $httpHost = 'https://';
}else{
    preg_match('@^(?:http://)?([^/]+)@i',$link, $matches);
    $httpHost = 'http://';
}

$host = $matches[1];

// извлекаем две последние части имени хоста
preg_match('/[^.]+\.[^.]+$/', $host, $matches);
$host = $matches[0];

$list = array();

foreach ($domains as $domain) {


    $array = array_merge($domain->toArray(), array('link' => $httpHost . $domain->get('domain') . '.' . $host));

    $list[] = $pdoTools
        ? $pdoTools->getChunk($tpl, $array)
        : $modx->getChunk($tpl, $array);
}

$output = implode($list);
return $output;