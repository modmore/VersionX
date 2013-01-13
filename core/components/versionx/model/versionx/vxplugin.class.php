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
class vxPlugin extends xPDOObject {
    public static $excludeFields = array(
        'version_id',
        'saved',
        'user',
        'mode',
        'marked',
    );

    public static $tabJavascript = array(
        'plugins/panel.plugins.js',
        'plugins/grid.plugins.js',
    );

    public static $tabTpl = 'mgr/tabs/plugins';
    /**
     * Gets the excluded fields.
     * @static
     * @return array
     */
    public static function getExcludeFields () {
        return self::$excludeFields;
    }
    /**
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
     * Reverts a snippet to the selected version.
     * @param array $options
     *
     * @return bool
     */
    public function revert(array $options = array()) {
        if (!$this->get('content_id')) {
            return false;
        }

        /* @var modPlugin $object */
        $object = $this->xpdo->getObject('modPlugin',$this->get('content_id'));
        if (!($object instanceof modPlugin)) {
            /* Could not find the snippet, so we'll assume it was deleted. We'll create a new one and force that ID. */
            $object = $this->xpdo->newObject('modPlugin');
            $object->set('id', $this->get('content_id'));
        }

        $object->fromArray(array(
            'name' => $this->get('name'),
            'description' => $this->get('description'),
            'category' => ($this->xpdo->getCount('modCategory',array('id' => $this->get('category'))) > 0) ? $this->get('category') : 0,
            'plugincode' => $this->get('plugincode'),
            'locked' => $this->get('locked'),
            'disabled' => $this->get('disabled'),
        ), '', true);

        return $object->save();
    }
}
