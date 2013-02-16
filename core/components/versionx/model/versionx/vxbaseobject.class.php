<?php
/**
 * VersionX
 *
 * Copyright 2011-2013 by Mark Hamstra <hello@markhamstra.com>
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
abstract class vxBaseObject extends xPDOObject {
    /**
     * Gets fields to exclude from comparisons between versions.
     * @static
     * @return array
     */
    public static function getExcludeFields () {
        return array(
            'version_id',
            'saved',
            'user',
            'mode',
            'marked',
        );
    }
    /**
     * Gets an array of javascript files needed for the version tabs.
     *
     * @static
     * @return array
     */
    public static function getTabJavascript() {
        return array();
    }

    /**
     * Gets the tab template file name.
     * @static
     * @return string
     */
    public static function getTabTpl() {
        return '';
    }
}
