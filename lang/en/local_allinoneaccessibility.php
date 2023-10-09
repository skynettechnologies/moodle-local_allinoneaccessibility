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
 * Language strings definition
 *
 * @package     local_allinoneaccessibility
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$current_domain=isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'-';
$string['pluginname'] = 'All In One Accessibility';
$string['allinoneaccessibilitydesc'] = 'All In One Accessibility';
$string['allinoneaccessibility:allow'] = 'Allow all for user roles';


$string['aioa-licensekey'] = 'License Key';
$string['aioa-licensekeydesc'] = 'Please <a href="https://www.skynettechnologies.com/add-ons/cart/?add-to-cart=116&variation_id=117&quantity=1&utm_source='.$current_domain.'&utm_medium=moodle-module&&utm_campaign=purchase-plan">Upgrade</a> to full version of All in One Accessibility Pro.';
$string['aioa-is_enabled'] = 'Enable';
$string['aioa-yes'] = 'Yes';
$string['aioa-no'] = 'No';
$string['aioa-colorcode'] = 'Hex color code:';
$string['aioa-colorcodedesc'] = 'You can customize the ADA Widget color. For example: FF5733';
$string['aioa-iconposition'] = 'Icon Position:';
$string['aioa-iconpositiondesc'] = 'Where would you like to place the accessibility icon on your site?';


$string['aioa-icontype'] = 'Select icon type:';
$string['aioa-icon-type-1'] = 'Accessibility';
$string['aioa-icon-type-2'] = 'Wheelchair';
$string['aioa-icon-type-3'] = 'Low Vision';

$string['aioa-icontypedesc'] = '<div class="row">
<div class="col-md-1">'.$string['aioa-icon-type-1'].'</div>
<div class="col-md-1">'.$string['aioa-icon-type-2'].'</div>
<div class="col-md-2">'.$string['aioa-icon-type-3'].'</div>
</div><div class="row mb-3">
<div class="col-md-1"><img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-1.svg" width="55" height="55" style="background-color:#6f42c1;border-radius:100%"></div>
<div class="col-md-1"><img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-2.svg" width="55" height="55" style="background-color:#6f42c1;border-radius:100%"></div>
<div class="col-md-2"><img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-3.svg" width="55" height="55" style="background-color:#6f42c1;border-radius:100%"></div>
</div><script>
    function aiwidgetapikeychange(){
        var toggleControls = document.getElementById("id_s_local_allinoneaccessibility_licensekey");
        var selector_value = toggleControls.value;
        var adminiconsize = document.getElementById(\'admin-iconsize\');
        var adminicontype = document.getElementById(\'admin-icontype\');
        adminiconsize.style.display = "none";
        adminicontype.style.display = "none";
        if(selector_value!="") {
            adminiconsize.style.display = "";
            adminicontype.style.display = "";
        }
    }
    var toggleControls1 = document.getElementById("id_s_local_allinoneaccessibility_licensekey");
    toggleControls1.addEventListener("change", function(event) {
        aiwidgetapikeychange();
    });
    window.addEventListener("load", function() {
        aiwidgetapikeychange();
    });
</script>';

$string['aioa-top_left'] = 'Top Left';
$string['aioa-top_center'] = 'Top Center';
$string['aioa-top_right'] = 'Top Right';
$string['aioa-middel_left'] = 'Middle Left';
$string['aioa-middel_right'] = 'Middle Right';
$string['aioa-bottom_left'] = 'Bottom Left';
$string['aioa-bottom_center'] = 'Bottom Center';
$string['aioa-bottom_right'] = 'Bottom Right';

$string['aioa-iconsize'] = 'Select icon size:';
$string['aioa-iconsizedesc'] = '';

$string['aioa-big-icon'] = 'Big';
$string['aioa-medium-icon'] = 'Medium';
$string['aioa-default-icon'] = 'Default';
$string['aioa-small-icon'] = 'Small';
$string['aioa-extra-small-icon'] = 'Extra Small';