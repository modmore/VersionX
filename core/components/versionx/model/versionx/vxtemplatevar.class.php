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
class vxTemplateVar extends vxBaseObject {
    /**
     * {@inheritdoc}
     * @return array
     */
    public static function getTabJavascript () {
        return array(
            'templatevars/panel.templatevars.js',
            'templatevars/grid.templatevars.js',
        );
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    public static function getTabTpl () {
        return 'mgr/tabs/templatevars';
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

        /* @var modTemplateVar $object */
        $object = $this->xpdo->getObject('modTemplateVar',$this->get('content_id'));
        if (!($object instanceof modTemplateVar)) {
            /* Could not find the TV, so we'll assume it was deleted. We'll create a new one and force that ID. */
            $object = $this->xpdo->newObject('modTemplateVar');
            $object->set('id', $this->get('content_id'));
        }

        $object->fromArray(array(
            'name' => $this->get('name'),
            'caption' => $this->get('caption'),
            'description' => $this->get('description'),
            'category' => ($this->xpdo->getCount('modCategory',array('id' => $this->get('category'))) > 0) ? $this->get('category') : 0,
            'rank' => $this->get('rank'),
            'display' => $this->get('display'),
            'default_text' => $this->get('default_text'),
            'properties' => $this->get('properties'),
            'input_properties' => $this->get('input_properties'),
            'output_properties' => $this->get('output_properties'),
        ), '', true);

        return $object->save();
    }

}
