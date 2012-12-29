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
class vxTemplate extends xPDOObject {
    public static $excludeFields = array(
        'version_id',
        'saved',
        'user',
        'mode',
        'marked',
    );
    
    public static $tabJavascript = array(
        'templates/panel.templates.js',
        'templates/grid.templates.js',
    );
    
    public static $tabTpl = 'mgr/tabs/templates';
    
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
     * Reverts a template to the selected version.
     * @param array $options
     *
     * @return bool
     */
    public function revert(array $options = array()) {
        if (!$this->get('content_id')) {
            return false;
        }

        /* @var modTemplate $template */
        $template = $this->xpdo->getObject('modTemplate',$this->get('content_id'));
        if (!($template instanceof modTemplate)) {
            /* Could not find the template, so we'll assume it was deleted. We'll create a new one and force that ID. */
            $template = $this->xpdo->newObject('modTemplate');
            $template->set('id', $this->get('content_id'));
        }

        $template->fromArray(array(
            'templatename' => $this->get('templatename'),
            'description' => $this->get('description'),
            'category' => ($this->xpdo->getCount('modCategory',array('id' => $this->get('category'))) > 0) ? $this->get('category') : 0,
            'content' => $this->get('content'),
            'locked' => $this->get('locked'),
        ), '', true);

        return $template->save();
    }
}
