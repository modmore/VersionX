<?php
$output ='';
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UNINSTALL:
    case xPDOTransport::ACTION_UPGRADE:
        $output = 'Remove existing tables? <input type="checkbox" name="removedb" id="rex-removedb" selected="selected" />';
        break;
}
return $output;