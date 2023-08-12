<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * Local Redirect
 *
 * This local plugin that adds a 'friendly url' version of Google analytics
 * to Moodle
 *
 * @package    local
 * @subpackage local_allinoneaccessibility
 * @copyright  2023
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function local_allinoneaccessibility_before_footer()
{
    global $PAGE;
    $widget_setting_ada=get_config('local_allinoneaccessibility');
    
    /*$widget_setting_ada = ga_widget_settings();*/
    $isenabled = isset($widget_setting_ada->isenabled)?$widget_setting_ada->isenabled:'no';
    $color = isset($widget_setting_ada->colorcode)?$widget_setting_ada->colorcode:'0678be';
    $color = trim(str_replace('#','',$color));
    $token = isset($widget_setting_ada->licensekey)?$widget_setting_ada->licensekey:'';
    $iconposition = isset($widget_setting_ada->iconposition)?$widget_setting_ada->iconposition:'';
    $iconsize = isset($widget_setting_ada->iconsize)?$widget_setting_ada->iconsize:'aioa-default-icon';
    $icontype = isset($widget_setting_ada->icontype)?$widget_setting_ada->icontype:'aioa-icon-type-1';
    $time=rand(0,10);
    
    /*$settings = Array('colorcode', 'iconposition');
    $show = false;
    foreach ($settings as $setting) {
        if (trim(get_config('local_allinoneaccessibility', $setting)) != '') {
            $show = true;
            break;
        }
    }*/
    $excludepages = Array('admin', 'embedded', 'frametop', 'maintenance', 'popup','print', 'redirect', 'report');
    if($isenabled=='yes' && !in_array($PAGE->pagelayout, $excludepages)) {
        $request_param='colorcode=#'.$color.'&token='.$token.'&t='.$time.'&position='.$iconposition.'.'.$icontype.'.'.$iconsize;
        echo "<script id='aioa-adawidget' src='https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?$request_param'></script>";
    }
}