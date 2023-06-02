# VersionX 3 #

_If you're looking for the current stable version of VersionX, see the [v2 branch](https://github.com/modmore/VersionX/tree/master)._

VersionX is a versioning system for the MODX content management system. It keeps track of changes to your resources, templates, template variables, chunks, snippets, plugins, and _now in v3 custom objects too!_ You can view historic changes and revert changes from a simple dashboard.

![VersionX Screenshot](https://user-images.githubusercontent.com/5160368/236378160-f0e88939-71e4-4d38-b750-f49ae84b068d.png)

v3.0 is a complete rewrite and is not compatible with v2. 
There is, however, a migration utility included that will assist with moving your old data to the new tables.

## The Road to v3.0 ##
Version 3 would not have been possible if not for the impressive community funding. _[More on this soon...]_

## Requirements ##

- MODX 2.6.5+ 
- PHP 7.4+

## Installation ## 

VersionX can be installed from either the [modmore package provider](https://modmore.com/about/package-provider/), or the [MODX package provider](https://extras.modx.com/package/versionx?version=2.4.0-pl).

## New UI ##
_Coming soon..._

## Deltas ##
_Coming soon..._

## Fields ##
_Coming soon..._

## Object Types ##

Objects may be expected to behave differently from one another. We expect when saving a resource, it should also remember the TV values on that resource, whereas when saving a chunk, we don't need to worry about that. 

To handle these different behaviours, VersionX uses configuration classes that extend the `\modmore\VersionX\Types\Type` class.

Here's the object _Type_ class for a core chunk:

```php
<?php

namespace modmore\VersionX\Types;

class Chunk extends Type
{
    // The class to be versioned
    protected string $class = \modChunk::class;
    
    // The id of the HTML element where the "Versions" tab will be added.
    protected string $tabId = 'modx-chunk-tabs';
    
    // The id of the ExtJS panel where versions will be rendered
    protected string $panelId = 'modx-panel-chunk';
    
    // Package name. If you're versioning a custom object, change this from core.
    protected string $package = 'core';
    
    // The primary field name for this object (for a resource it might be pagetitle)
    protected string $nameField = 'name';
    
    // List the field names to appear at the top when displaying diffs.
    protected array $fieldOrder = [
        'name',
        'description',
        'content',
    ];
    
    // List field names that should not be versioned
    protected array $excludedFields = [
        'id',
        'snippet',
    ];
}
```

VersionX will check these values when performing actions. 

## Versioning Custom Objects ##

In addition to resources and elements, VersionX can work with custom objects. The only requirement is that it must be a derivative of xPDOObject. 

Example custom Type class for a Commerce product:

```php 
<?php

namespace MyModuleNamespace;

use modmore\VersionX\Fields\Image;
use modmore\VersionX\Fields\Properties;
use modmore\VersionX\Types\Type;

class MyProduct extends Type {
    protected string $class = \comProduct::class;
    protected string $package = 'commerce';
    protected string $nameField = 'name';
    protected array $excludedFields = [
        'id',
    ];
    protected array $fieldOrder = [
        'name',
        'description',
        'pricing',
        'sku',
    ];
    protected array $fieldClassMap = [
        'properties' => Properties::class,
        'image' => Image::class,
    ];
}
```

Here's an example of how to create a delta of an object using the MyProduct class above:

```php
$path = $modx->getOption('versionx.core_path', null, MODX_CORE_PATH . 'components/versionx/');
require $path . 'vendor/autoload.php';

$versionX = new \modmore\VersionX\VersionX($modx);

$type = new \MyModuleNamespace\MyProduct($versionX);
$result = $versionX->deltas()->createDelta($id, $type);
```

Here we are getting the VersionX autoloader (so PHP knows where the VersionX classes are), then instantiating VersionX, instantiating our own custom "Object Type", then calling `createDelta()` and passing our custom Object Type `$type` and the `$id` of the object we want to version.

You can see an [example of this in the VersionX plugin](https://github.com/modmore/VersionX/blob/3.x/core/components/versionx/elements/plugins/versionx.plugin.php#L41-L42), where we are creating a new delta of a resource when saved. The Object Type in this case is `\modmore\VersionX\Types\Resource`.

```php
$type = new \modmore\VersionX\Types\Resource($versionX);
$result = $versionX->deltas()->createDelta($id, $type);
```

Now what happens if you want to include extra data in the delta that's not a field of your object? Saving TV values along with resources are an excellent example of this. [coming soon]



## Merging Deltas ##
_Coming soon..._

## Milestones ##
_Coming soon..._

## Migrating from 2.x ##
_Coming soon..._

## Contributions ##
VersionX is open source, and free to use. If you would like to support further development, feel free to contribute with either code (in the form of a PR on this repo) or monetary contributions. Hit the link to donate: https://modmore.com/extras/versionx/donate/ 
