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
class vxChunk extends xPDOObject {
    public static $excludeFields = array(
        'version_id',
        'saved',
        'user',
        'mode',
        'marked',
    );

    public static $tabJavascript = array(
        'chunks/panel.chunks.js',
        'chunks/grid.chunks.js',
    );

    public static $tabTpl = 'mgr/tabs/chunks';

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
     * Reverts a chunk to the selected version.
     * @param array $options
     *
     * @return bool
     */
    public function revert(array $options = array()) {
        if (!$this->get('content_id')) {
            return false;
        }

        /* @var modChunk $chunk */
        $chunk = $this->xpdo->getObject('modChunk',$this->get('content_id'));
        if (!($chunk instanceof modChunk)) {
            /* Could not find the chunk, so we'll assume it was deleted. We'll create a new chunk and force that ID. */
            $chunk = $this->xpdo->newObject('modChunk');
            $chunk->set('id', $this->get('content_id'));
        }

        $chunk->fromArray(array(
            'name' => $this->get('name'),
            'description' => $this->get('description'),
            'category' => ($this->xpdo->getCount('modCategory',array('id' => $this->get('category'))) > 0) ? $this->get('category') : 0,
            'snippet' => $this->get('snippet'),
            'locked' => $this->get('locked'),
        ), '', true);


        return $chunk->save();
    }
}
