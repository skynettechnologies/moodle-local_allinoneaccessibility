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
 * Local All In One Accessibility
 *
 * Quick Web Accessibility Implementation with All In One Accessibility!
 *
 * @package local_allinoneaccessibility
 * @copyright  2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
/**
 * Render the setting for widget.
 *
 * @return void
 */
function local_allinoneaccessibility_before_footer() {
    global $PAGE;
    $widgetsettingada = get_config('local_allinoneaccessibility');
    $isenabled = isset($widgetsettingada->isenabled) ? $widgetsettingada->isenabled : 'no';
    $color = isset($widgetsettingada->colorcode) ? $widgetsettingada->colorcode : '0678be';
    $color = trim(str_replace('#', '', $color));
    $token = isset($widgetsettingada->licensekey) ? $widgetsettingada->licensekey : '';
    $iconposition = isset($widgetsettingada->iconposition) ? $widgetsettingada->iconposition : '';
    $iconsize = isset($widgetsettingada->iconsize) ? $widgetsettingada->iconsize : 'aioa-default-icon';
    $icontype = isset($widgetsettingada->icontype) ? $widgetsettingada->icontype : 'aioa-icon-type-1';
    $time = rand(0, 10);
    $currentdomain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '-';
    $excludepages = Array('admin', 'embedded', 'frametop', 'maintenance', 'popup', 'print', 'redirect', 'report');
    $licensekeymessage = get_string('aioa-licensekeydesc', 'local_allinoneaccessibility');
    $upgrademessage = get_string('aioa-upgrade', 'local_allinoneaccessibility');
    if ($isenabled == 'yes' && !in_array($PAGE->pagelayout, $excludepages)) {
        $requestparam = 'colorcode=#'.$color.'&token='.$token.'&t='.$time.'&position='.$iconposition.'.'.$icontype.'.'.$iconsize;
        $script = "<script id='aioa-adawidget' src='https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility";
        $script .= "-js-widget-minify.js?$requestparam'></script>";
        echo $script;
    } else if ($PAGE->pagelayout == 'admin') {
        echo '<script>
        function aiwidgetapikeychange(){
            var toggleControls = document.getElementById("id_s_local_allinoneaccessibility_licensekey");
            var selector_value = toggleControls.value;
            var adminiconsize = document.getElementById(\'admin-iconsize\');
            var adminicontype = document.getElementById(\'admin-icontype\');
            adminiconsize.style.display = "none";
            adminicontype.style.display = "none";
            var keypurchase_msg = "<p>'.$licensekeymessage.'<br> <a href=\'https://www.skynettechnologies.com/add-ons/cart/?add-to-cart=116&variation_id=117";
            keypurchase_msg += "&quantity=1&utm_source='.$currentdomain.'";
            keypurchase_msg += "&utm_medium=moodle-module&&utm_campaign=purchase-plan\'>'.$upgrademessage.'</a>";
            document.querySelector("#admin-licensekey > .form-setting > .form-description").innerHTML=keypurchase_msg;
            if (selector_value!="") {
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
         if (toggleControls1.value=="") {
            var request = new XMLHttpRequest();
            var url =  \'https://www.skynettechnologies.com/add-ons/discount_offer.php?platform=moodle?\';
            request.open(\'POST\', url, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.onreadystatechange = function() {
                if (request.readyState === XMLHttpRequest.DONE) {
                    if (request.status === 200 && request.response!="") {
                        //console.log(request.response);
                        const form_tag = document.getElementById("adminsettings");
                        const form_tag_parentElement = form_tag.querySelector("fieldset");
                        console.log(form_tag_parentElement);
                        theKid = document.createElement("div");
                        theKid.innerHTML = request.response;
                        form_tag_parentElement.appendChild(theKid);
                        form_tag_parentElement.insertBefore(theKid, form_tag_parentElement.firstChild);
                    }
                }
            };
            request.send();
        }
        </script><style>.ada-banner-section{padding-left: inherit;}</style>';
    }
}
