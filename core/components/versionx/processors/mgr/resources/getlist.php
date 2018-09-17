<?php
/* @var modX $modx
 * @var array $scriptProperties
 */
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,20);
$sort = $modx->getOption('sort',$scriptProperties,'saved');
$dir = $modx->getOption('dir',$scriptProperties,'desc');

/* Filter data */
$search = $modx->getOption('search',$scriptProperties,null);
$resource = $modx->getOption('resource',$scriptProperties,null);
$context = $modx->getOption('context',$scriptProperties,null);
$class = $modx->getOption('class',$scriptProperties,null);
$user = $modx->getOption('user',$scriptProperties,null);
$from = $modx->getOption('from',$scriptProperties,null);
$until = $modx->getOption('until',$scriptProperties,null);

$results = array();

$c = $modx->newQuery('vxResource');
$c->leftJoin('modUser','User');
$c->leftJoin('modUserProfile','Profile','Profile.internalKey = User.id');
$c->leftJoin('modContextSetting','ContextSetting','ContextSetting.context_key = vxResource.context_key');
$c->leftJoin('modResourceGroupResource','ResourceGroup','ResourceGroup.document = vxResource.content_id');
$c->select(array('vxResource.version_id','vxResource.content_id','vxResource.saved','vxResource.mode','vxResource.marked','vxResource.title','vxResource.context_key','vxResource.class','User.username'));

/* Filter */
if ($search)
    $c->where(array('title:LIKE' => "%$search%"));
if ($resource && is_numeric($resource))
    $c->where(array('content_id' => (int)$resource));
if ($context)
    $c->where(array('context_key' => $context));
if ($class)
    $c->where(array('class' => $class));
if ($user && is_numeric($user))
    $c->where(array('user' => (int)$user));
if ($from)
    $c->where(array('saved:>' => $from));
if ($until)
    $c->where(array('saved:<' => $until));

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

$collection = $modx->getCollection('vxResource',$c);

/* @var vxResource $res */
foreach ($collection as $res) {
    $ta = $res->toArray('',false,true);
    $results[] = $ta;
}

$returnArray = array(
    'success' => true,
    'total' => $total,
    'results' => $results
);
return $modx->toJSON($returnArray);

