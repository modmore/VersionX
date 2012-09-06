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
/* @var modX $modx */


if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_UPGRADE:
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;

            $modelPath = $modx->getOption('versionx.core_path',null,$modx->getOption('core_path').'components/versionx/').'model/';
            $modx->addPackage('versionx',$modelPath);
            $manager = $modx->getManager();
            $loglevel = $modx->setLogLevel(modX::LOG_LEVEL_ERROR);

            $objects = array('vxResource','vxTemplate','vxSnippet','vxChunk','vxPlugin','vxTemplateVar');
            foreach ($objects as $obj) {
                $manager->createObjectContainer($obj);
            }
            $modx->setLogLevel($loglevel);
        break;
    }

}
return true;

