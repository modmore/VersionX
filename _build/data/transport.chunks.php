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

$chunks = array();
$x=0;
$chunks[++$x]= $modx->newObject('modChunk');
$chunks[$x]->fromArray(array(
    'id' => $x,
    'name' => 'VersionxApproveEmailTpl',
    'description' => 'Email that is sent out on approval of a resource',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/versionxapproveemailtpl.html'),
    'properties' => '',
),'',true,true);

$chunks[++$x]= $modx->newObject('modChunk');
$chunks[$x]->fromArray(array(
    'id' => $x,
    'name' => 'VersionxRejectEmailTpl',
    'description' => 'Email that is sent out on rejection of a resource',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/versionxrejectemailtpl.html'),
    'properties' => '',
),'',true,true);

$chunks[++$x]= $modx->newObject('modChunk');
$chunks[$x]->fromArray(array(
    'id' => $x,
    'name' => 'VersionxSubmitEmailTpl',
    'description' => 'Email that is sent out on submitting a resource',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/versionxsubmitemailtpl.html'),
    'properties' => '',
),'',true,true);
return $chunks;