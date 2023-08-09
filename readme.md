# VersionX 3 #

_If you're looking for the current stable version of VersionX, see the [v2 branch](https://github.com/modmore/VersionX/tree/master)._

VersionX is a versioning system for the MODX content management system. It keeps track of changes to your resources, templates, template variables, chunks, snippets, plugins, and _now in v3 custom objects too!_ You can view historic changes and revert changes from a simple dashboard.

![VersionX Screenshot](https://user-images.githubusercontent.com/5160368/236378160-f0e88939-71e4-4d38-b750-f49ae84b068d.png)

v3.0 is a complete rewrite and is not compatible with v2. 
There is, however, a migration utility included that will assist with moving your old data to the new tables.

## Funding Goal Reached ##

VersionX 3.0 was made possible by community funding. Special thanks to:

- <a href="https://jens-wittmann.de" target="_blank" rel="noopener">Jens Wittmann</a>
- <a href="https://www.quadro-system.de/" target="_blank" rel="noopener"><img src="https://assets.modmore.com/modxpo2022/sp/quadro.svg" alt="QUADRO"></a>
- <a href="https://www.webaix.de/" target="_blank" rel="noopener"><img src="https://assets.modmore.com/modxpo2022/sp/webaix-logo-2021.svg" alt="webaix."></a>
- <a href="https://www.visions.ch/" target="_blank" rel="noopener"><img src="https://assets.modmore.com/modxpo2022/sp/logo_visions.svg" alt="Visions"></a>
- <a href="https://www.lux-medien.com/" target="_blank" rel="noopener"><img src="https://assets.modmore.com/modxpo2022/sp/logo-lux-tiny-2019.svg" alt="LUX Medien"></a>
- <a href="https://sepiariver.com/" target="_blank" rel="noopener">Sepia River Studios</a>
- Joshua Lückers

## Requirements ##

- MODX 2.6.5+ 
- PHP 7.4+

## Installation ## 

VersionX can be installed from either the [modmore package provider](https://modmore.com/about/package-provider/), or the [MODX package provider](https://extras.modx.com/package/versionx?version=2.4.0-pl).

## New UI ##
The UI in VersionX 3.0 has been overhauled and simplified. 

**Manager Page**

The VersionX manager page is availble at `Extras -> VersionX` in the MODX manager. 
Here you'll find the main objects grid that lists all objects that have at least one version stored.
They are sorted by the latest update, and can be filtered by the package they belong to, the type of 
object (Resource, Template, Chunk, Snippet, TV, Plugin, or custom), the user who made the update and the date.

By default, only core object types are displayed. If you would like to include custom objects, please refer
to the sections **Object Types** and **Versioning Custom Objects** below.

To view the stored versions for an object, right-click on it and select `View Details`. A window will open 
with a list of deltas for that object. Each delta represents a grouping of all the fields that changed at a 
particular point in time. Inside each delta you'll see a list of rendereded 
[diffs](https://en.wikipedia.org/wiki/Diff) for each field name showing the before and after values.]

**Versions Tab**

On each Resource and Element manager page, you'll see an extra "Versions" tab that's been added by VersionX.
Switching to this tab will display the same list of deltas as when opening the detail window on the 
VersionX manager page.

## Reverting Changes ##

Reverting changes is performed either on the versions tab of the manager Resource/Element form, or via the
main VersionX manager page.

Look through the list of deltas, and find the one you want to revert to. There are three buttons available
for reverting.

- `Undo`: On the right-hand side of every diff, you'll see **_undo_** buttons for each field listed. Clicking undo will revert the change for that field only, ignoring all the other fields within that delta.
- `Revert these changes`: In the top-right corner of each delta, you'll see the **_Revert these changes_** button. This will revert all fields within that delta, but no others.
- `Revert all fields to this point in time`: This button sits between deltas, and reverts ALL fields regardless of which delta they are in, to that point in time. (_This point in time_ refers to the "end time" of the delta just below it).

## Fields ##

Different field types in v3 allow for unique behavior when creating, reverting, or rendering deltas. In addition to the standard [Text field](https://github.com/modmore/VersionX/blob/3.x/core/components/versionx/src/Fields/Text.php), the [Properties field](https://github.com/modmore/VersionX/blob/3.x/core/components/versionx/src/Fields/Properties.php) is now available.

Properties fields are defined for an object in the type class (see Object Types section below) and are typically used for fields that contain more than one value, 
such as a serialized value. The properties field breaks the value apart recursively and versions each item as its own field when stored in a delta. 
This provides more granular control over what can be reverted, compared to a normal Text field where all values must be reverted at once. 
An example of the Properties field being defined for a Resource can be found [here](https://github.com/modmore/VersionX/blob/3.x/core/components/versionx/src/Types/Resource.php#L32-L34).

An Image field is also planned that would allow rendering of the before and after images within the diff.

## Object Types ##

Objects may be expected to behave differently from one another. We expect when saving a resource, it should also remember the TV values on that resource, whereas when saving a chunk, we don't need to worry about that. 

To handle these different behaviours, VersionX uses configuration classes that extend the `\modmore\VersionX\Types\Type` class.

Here's the object _Type_ class for versioning chunks (modChunk):

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
    
    /**
     * Here we are loading the Commerce package via it's service class. This is required in order to have 
     * custom objects show up in the main VersionX objects grid.
     */
    public static function loadCustomPackage(\modX $modx): bool
    {
        // While we're using $modx->getService() here, depending on your package/objects you might use
        // $modx->loadClass(), or $modx->addPackage() instead.
        if (!$modx->getService('commerce', 'Commerce', MODX_CORE_PATH . 'components/commerce/model/commerce/')) {
            // Return false if it failed
            return false;
        }
        
        return true;
    }
}
```

**Create versions of a custom object**

Here's an example of how to create a delta of an object using the MyProduct type class above:

```php
$path = $modx->getOption('versionx.core_path', null, MODX_CORE_PATH . 'components/versionx/');
require $path . 'vendor/autoload.php';

$versionX = new \modmore\VersionX\VersionX($modx);

$type = new \MyModuleNamespace\MyProduct($versionX);
$result = $versionX->deltas()->createDelta($id, $type);
```

Here we are getting the VersionX autoloader (so PHP knows where the VersionX classes are), then instantiating VersionX, instantiating our own custom type class, then calling `createDelta()` and passing our custom type class `$type` and the `$id` of the object we want to version.

You can see an [example of this in the VersionX plugin](https://github.com/modmore/VersionX/blob/3.x/core/components/versionx/elements/plugins/versionx.plugin.php#L41-L42), where we are creating a new delta of a resource when saved. The Object Type in this case is `\modmore\VersionX\Types\Resource`.

```php
$type = new \modmore\VersionX\Types\Resource($versionX);
$result = $versionX->deltas()->createDelta($id, $type);
```

Now what happens if you want to include extra data in the delta that's not a field of your object? 
Saving TV values along with resources are an excellent example of this. In your extended custom type class, you
can use the [includeFieldsOnCreate()](https://github.com/modmore/VersionX/blob/3.x/core/components/versionx/src/Types/Type.php#L162-L173) method to add extra data to the version. An [example of this](https://github.com/modmore/VersionX/blob/3.x/core/components/versionx/src/Types/Resource.php#L42-L105) can be 
found in the `Resource` type class.

When reverting to a previous version of an object, you're going to want to revert the values of those 
extra fields to the values from the previous version. To do this use the [afterRevert()](https://github.com/modmore/VersionX/blob/3.x/core/components/versionx/src/Types/Type.php#L186-L202) method in your 
extended Type class. See the example reverting TV values in the [Resource](https://github.com/modmore/VersionX/blob/3.x/core/components/versionx/src/Types/Resource.php#L108-L152) class.


**Display the custom object versions in the VersionX grid**

The most important part for custom objects is the `loadCustomPackage()` method, as seen in the example above. 
This will allow the main VersionX objects grid to display your custom object versions in addition to the regular core objects.
This method should be used to load the xPDO objects. Different packages may need to be loaded in different ways; for example 
in the example above the Commerce package is loaded by using the `$modx->getService()` method. For other packages, it might
be more appropriate to use `$modx->loadClass()`, `$modx->addPackage()`, or the MODX 3+ `bootstrap.php` file.

Your custom type class could be located anywhere, so we need to let VersionX know where to find it. For this 
the `versionx.custom_type_classes` system setting exists. The class name and the file location of each custom package should be added in JSON format to the system setting.
e.g.

```json
[{
  "class": "\\MyModuleNamespace\\MyProduct",
  "path": "{core_path}components/commerce_mymodule/src/MyModuleNamespace/MyProduct.php"
},{
  "class": "\\AnotherNamespace\\AnotherClass",
  "path": "{core_path}components/packagename/src/AnotherNamespace/AnotherClass.php"
}]
```

VersionX will check this system setting when loading the main objects grid, and then run the `loadCustomPackage()` method 
for each class listed there.

You can then see your custom object versions in the VersionX grid. Note the object with the name `MyProduct` and the 
class `comProduct` listed in the screenshot below:

![Custom Object in Grid](https://github.com/modmore/VersionX/assets/5160368/bf323859-a971-47cf-8a90-5904426179ee)


## Merging Deltas ##

Previously, VersionX stored the entire object each save. This, as you can imagine, caused the database tables to grow rather quickly.
As of v3, each version only contains the fields that have changed within a delta.

Merging deltas are a key function of VersionX, designed to keep storage space to a minimum. Merging deltas is intended
to be handled by a nightly cronjob, though it can also be triggered manually by the **_Optimise Storage_** button at 
the top of the VersionX manager page.

The script to run for the cron is located at `core/components/versionx/cron.php`

So to run it every midnight, in your crontab you might put:
```
0 0 * * * php /var/www/public/core/components/versionx/cron.php > /dev/null 2>&1
```

VersionX will look at how old deltas are and merge then depending on the timeframe.

- `1 week ago` - Deltas older than a week will be merged to a single delta for a given hour.
  _This leaves at most 168 unique deltas per object per week, or 8736 per year._
- `1 month ago` - Deltas older than a month will be merged to a single delta for a given day.
  _This leaves at most 7 unique deltas per object per week, or 364 per year_
- `3 months ago` - Deltas older than 3 months will be merged to a single delta for a given week.
  _This leaves at most 1 unique delta per object per week, or 52 per year._
- `18 months ago` - Deltas older than 18 months will be merged to a single delta for a given month.
  _This leaves at most 1 unique delta per object per month, or 12 per year._
- `5 years ago` - Deltas older than 5 years will be merged to a single delta for a given year.

The initial delta on each object, plus any delta marked as a **_milestone_** will not be merged.

## Milestones ##

Within the delta grid UI, you can set a milestone tag (e.g. "Client Review" or "Went Live!") on a delta by 
clicking the flag icon.
A milestone represents an important version that should be preserved as is, and as such is never merged.
Click the milestone tag again to remove it if you no longer wish to keep it separate.

## Migrating from 2.x ##

A separate script has been included to migrate version data from the VersionX 2.x database tabled.

After upgrading to version 3, run the following from the command line:
```
php /your/path/core/components/versionx/migrate.php
```

## Contributions ##
VersionX is open source, and free to use. If you would like to support further development, feel free to contribute with either code (in the form of a PR on this repo) or monetary contributions. Hit the link to donate: https://modmore.com/extras/versionx/donate/ 
