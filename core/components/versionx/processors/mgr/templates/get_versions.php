<?php
/* @var modX $modx
 * @var array $scriptProperties 
 */
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,20);
$sort = $modx->getOption('sort',$scriptProperties,'version_id');
$dir = $modx->getOption('dir',$scriptProperties,'desc');

$search = $modx->getOption('query',$scriptProperties,'');
$template = intval($modx->getOption('template',$scriptProperties,0));
$current = intval($modx->getOption('current',$scriptProperties,0));

$c = $modx->newQuery('vxTemplate');
$c->select(array('version_id','saved','mode'));

if (strlen($search) > 1) {
    $c->where(array('id:LIKE' => "%$search%",));
}
if ($template > 0)
    $c->where(array('content_id' => $template));
if ($current > 0)
    $c->where(array('version_id:!=' => $current));

$total = $modx->getCount('vxTemplate',$c);

$c->sortby($sort,$dir);
$c->limit($limit,$start);

$results = array();
$query = $modx->getCollection('vxTemplate',$c);
/* @var vxTemplate $r */
foreach ($query as $r) {
    $ta = $r->toArray('',false,true);
    $results[] = array(
        'id' => $ta['version_id'],
        'display' => '#'.$ta['version_id'] . ': ' . $modx->lexicon('versionx.mode.'.$ta['mode']) . ' at ' . date($modx->config['manager_date_format'] . ' ' . $modx->config['manager_time_format'], strtotime($ta['saved'])),
    );
}

$returnArray = array(
    'success' => true,
    'total' => $total,
    'results' => $results
);
return $modx->toJSON($returnArray);
