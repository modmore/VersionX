<?php
/**
 * VersionX
 *
 * Copyright 2011 by Mark Hamstra <hello@markhamstra.com>
 *
 * This file is part of VersionX, a real estate property listings component
 * for MODX Revolution.
 *
 * VersionX is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * VersionX is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * VersionX; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
*/
class vxResource extends xPDOObject {
    public static $excludeFields = array(
        'version_id',
        'saved',
        'user',
        'mode',
        'marked',

        'fields' => array(
            'createdon',
            'createdby',
            'editedon',
            'editedby',
        )
    );
    
    public static $tabJavascript = array(
        'resources/panel.resources.js',
        'resources/grid.resources.js',
    );
    
    public static $tabTpl = 'mgr/tabs/resources';

    /**
     * Gets the excluded fields.
     * @static
     * @return array
     */
    public static function getExcludeFields () {
        return self::$excludeFields;
    }

    /**
     * Gets the Javascript filenames that are required for tabs.
     * @static
     * @return array
     */
    public static function getTabJavascript() {
        return self::$tabJavascript;
    }

    /**
     * Gets the tab template file name.
     * @static
     * @return string
     */
    public static function getTabTpl() {
        return self::$tabTpl;
    }

    /**
     * Reverts a resource to the selected version.
     * @param array $options
     *
     * @return bool
     */
    public function revert(array $options = array()) {
        if (!$this->get('content_id')) {
            return false;
        }

        /* @var modResource $resource */
        $resource = $this->xpdo->getObject('modResource',$this->get('content_id'));
        if (!($resource instanceof modResource)) {
            /* Could not find the resource, so we'll assume it was deleted. We'll create a new resource and force that ID. */
            $resource = $this->xpdo->newObject($this->get('class'));
            $resource->set('id', $this->get('content_id'));
        }

        $content = $this->get('content');
        $fields = $this->get('fields');
        $tvs = $this->get('tvs');

        $resource->setContent($content);
        foreach ($fields as $key => $value) {
            if (in_array($key, array('id', 'type'))) { continue; }
            $resource->set($key, $value);
        }

        foreach ($tvs as $tv) {
            if (!$resource->setTVValue($tv['id'], $tv['value'])) {
                $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, '[VersionX:vxResource/revert] Resource: ' . $this->get('content_id') . ' | Unable of setting TV ' . $tv['id'] . ' to ' . $tv['value']);
                return false;
            }
        }

        return $resource->save();
    }
}

