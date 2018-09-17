<?php
/* @var modX $modx
 * @var array $scriptProperties 
 */
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,20);
$sort = $modx->getOption('sort',$scriptProperties,'version_id');
$dir = $modx->getOption('dir',$scriptProperties,'desc');

$search = $modx->getOption('query',$scriptProperties,'');
$resource = intval($modx->getOption('resource',$scriptProperties,0));
$current = intval($modx->getOption('current',$scriptProperties,0));

$c = $modx->newQuery('vxResource');
$c->leftJoin('modContextSetting','ContextSetting','ContextSetting.context_key = vxResource.context_key');
$c->leftJoin('modResourceGroupResource','ResourceGroup','ResourceGroup.document = vxResource.content_id');
$c->select(array('version_id','saved','mode'));

if (strlen($search) > 1) {
    $c->where(array('id:LIKE' => "%$search%",));
}
if ($resource > 0)
    $c->where(array('content_id' => $resource));
if ($current > 0)
    $c->where(array('version_id:!=' => $current));

/* 1. The connected context has is ignoring access through resource groups */
$where = [
    [
        [
            'ContextSetting.key' => 'access_resource_group_enabled',
            'ContextSetting.value' => 0
        ]
    ]
];

/* 2. The default context is ignoring access through resource groups disabled */
if(!$modx->getOption('access_resource_group_enabled', null, true)) {
    array_push($where, [
        'OR:vxResource.context_key:=' => $modx->getOption('default_context')
    ]);
    array_push($where[0], [
        'OR:ContextSetting.key' => 'access_resource_group_enabled',
        'ContextSetting.value:IS' => null,
    ]);
}

/* 3. The resource is not restricted or the user has access to the resourcegroup */
array_push($where, [
    'OR:ResourceGroup.id:IS' => null,
    'OR:ResourceGroup.document_group:IN' => $modx->user->getResourceGroups(),
]);
$c->where($where);
$total = $modx->getCount('vxResource',$c);

$c->sortby($sort,$dir);
$c->limit($limit,$start);

$results = array();
$query = $modx->getCollection('vxResource',$c);
/* @var vxResource $r */
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
