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
    public $debugVerification = false;
    /**
     * Checks the last saved version (if any).
     * Returns true if there is no earlier version, or something is different.
     * So if this returns true: go ahead and save the version.
     * If this returns false: nothing changed, don't bother.
     * 
     * @return bool
     */
    public function checkLastVersion() {
        /* Get last version to make sure we've got some changes to save */
        $c = $this->xpdo->newQuery('vxResource');
        $c->where(array('content_id' => $this->get('content_id')));
        $c->sortby('version_id','DESC');
        $c->limit(1);

        $lastVersion = $this->xpdo->getCollection('vxResource',$c);
        /* @var vxResource $lastVersion */
        $lastVersion = !empty($lastVersion) ? array_shift($lastVersion) : array();
        
        /* If there's no earlier version, we can go ahead and
         return true to indicate we need to save the version */
        if (!($lastVersion instanceof vxResource)) {
            return true;
        } 
        
        $lastVersionArray = $lastVersion->toArray();
        
        $exclude = array('version_id', 'saved','createdon','createdby','editedon','editedby','mode','user');
        foreach ($exclude as $ex) { unset($lastVersionArray[$ex]); }
        $newVersionArray = $this->toArray();
        foreach ($lastVersionArray as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k2 => $v2) {
                    if (!is_string($k2) || !in_array($k2,array('createdon','createdby','editedon'))) {
                        if (is_array($v2)) {
                            $v2string = '';
                            foreach ($v2 as $val) {
                                $v2string .= (is_array($val)) ? implode('',$val) : $val;
                            }
                            $v2 = $v2string;
                        }
                        if (is_array($newVersionArray[$key][$k2])) {
                            $v2string = '';
                            foreach ($newVersionArray[$key][$k2] as $val) {
                                $v2string .= (is_array($val)) ? implode('',$val) : $val;
                            }
                            $newVersionArray[$key][$k2] = $v2string;
                        }
                        if ($newVersionArray[$key][$k2] != $v2) {
                            /* Hey, something's different! 
                            Return true indicating to save a new version. */
                            if ($this->debugVerification) $this->xpdo->log(xPDO::LOG_LEVEL_ERROR,'Changed found in '.$key.': '.$newVersionArray[$key].' --- '. $value);
                            return true;
                        }
                    }
                }
            } else {
                if ($newVersionArray[$key] != $value) {
                    /* Hey, something's different! 
                    Return true indicating to save a new version. */
                    if ($this->debugVerification) $this->xpdo->log(xPDO::LOG_LEVEL_ERROR,'Changed found in '.$key.': '.$newVersionArray[$key].' --- '. $value);
                    return true;
                }
            }
        }
        if ($this->debugVerification) $this->xpdo->log(xPDO::LOG_LEVEL_ERROR,'No changes found.');
        /* If we got here, there was a last version but it seemed nothing was different.
        Return false to indicate to NOT save a new version. */
        return false;
    }
}
?>
