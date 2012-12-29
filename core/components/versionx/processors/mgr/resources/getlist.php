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
$c->select(array('version_id','content_id','saved','mode','marked','title','context_key','class','User.username'));

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

