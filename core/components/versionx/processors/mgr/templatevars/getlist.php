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
$tv = $modx->getOption('templatevar',$scriptProperties,null);
$category = $modx->getOption('category',$scriptProperties,null);
$user = $modx->getOption('user',$scriptProperties,null);
$from = $modx->getOption('from',$scriptProperties,null);
$until = $modx->getOption('until',$scriptProperties,null);

$results = array();

$c = $modx->newQuery('vxTemplateVar');
$c->leftJoin('modUser','User','User.id = vxTemplateVar.user');
$c->leftJoin('modUserProfile','Profile','Profile.internalKey = User.id');
$c->leftJoin('modCategory','Category','Category.id = vxTemplateVar.category');
$c->select(array('version_id','content_id','name','saved','mode','marked','vxTemplateVar.category','categoryname'=>'Category.category','User.username'));

/* Filter */
if ($search)
    $c->where(array('name:LIKE' => "%$search%"));
if ($tv)
    $c->where(array('content_id' => (int)$tv));
if ($category)
    $c->where(array('vxTemplateVar.category' => (int)$category));
if ($user && is_numeric($user))
    $c->where(array('user' => (int)$user));
if ($from)
    $c->where(array('saved:>' => $from));
if ($until)
    $c->where(array('saved:<' => $until));


$total = $modx->getCount('vxTemplateVar',$c);

$c->sortby($sort,$dir);
$c->limit($limit,$start);

$collection = $modx->getCollection('vxTemplateVar',$c);

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

