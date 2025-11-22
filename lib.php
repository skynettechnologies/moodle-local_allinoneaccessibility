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
    global $CFG;
    $widgetsettingada = get_config('local_allinoneaccessibility');
    
    $color = isset($widgetsettingada->colorcode) ? $widgetsettingada->colorcode : '0678be';
    $color = trim(str_replace('#', '', $color));
    $token = isset($widgetsettingada->licensekey) ? $widgetsettingada->licensekey : '';
    $iconposition = isset($widgetsettingada->iconposition) ? $widgetsettingada->iconposition : '';
    $iconsize = isset($widgetsettingada->iconsize) ? $widgetsettingada->iconsize : 'aioa-default-icon';
    $icontype = isset($widgetsettingada->icontype) ? $widgetsettingada->icontype : 'aioa-icon-type-1';
    $time = rand(0, 10);
    $currentdomain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '-';
    $excludepages = ['admin', 'embedded', 'frametop', 'maintenance', 'popup', 'print', 'redirect', 'report'];
    $licensekeymessage = get_string('aioa-licensekeydesc', 'local_allinoneaccessibility');
    $upgrademessage = get_string('aioa-upgrade', 'local_allinoneaccessibility');
    if (!in_array($PAGE->pagelayout, $excludepages)) {
        $requestparam = 'colorcode=#'.$color.'&token='.$token.'&t='.$time.'&position='.$iconposition.'.'.$icontype.'.'.$iconsize;
        $script = "<script id='aioa-adawidget' src='https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility";
        $script .= "-js-widget-minify.js?$requestparam'></script>";
        echo $script;
    } else if ($PAGE->pagelayout == 'admin') {
        $currenturl = new moodle_url($PAGE->url);
        $section = $currenturl->get_param('section', '');
        if($section == 'local_allinoneaccessibility') {
            $baseurl = $CFG->wwwroot;
            $arrRegResponse = local_allinoneaccessibility_register_domain($baseurl);
            include(__DIR__ . '/iparams.html');
            echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>';
        }
    }
}
/**
 * Executes a request to the given API and returns the response.
 *
 * @param string $url The URL of the API to which the request is sent.
 * @param array $data The data to send in the request body.
 * @return array The response from the API, usually in JSON format, as an associative array.
 */
function local_allinoneaccessibility_execute_request($apiurl, $data) {
    $adaapiurl = 'https://ada.skynettechnologies.us/api/'.$apiurl;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $adaapiurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        curl_close($ch);
        return [];
    } else {
        curl_close($ch);
        return json_decode($response, true);
    }
}

/**
 * Registers a domain with the external system.
 *
 * @param string $domain The domain name to register.
 * @return bool Returns `true` if the registration is successful, `false` otherwise.
 */
function local_allinoneaccessibility_register_domain($currentdomain) {
    $encodeddomain = base64_encode($currentdomain);
    $data = [
        'website' => $encodeddomain
    ];
    $apiurl = 'get-autologin-link-new';
    $responsearr = local_allinoneaccessibility_execute_request($apiurl, $data);
    if (!isset($responsearr['status']) || (isset($responsearr['status']) && $responsearr['status'] == 0)) {
        $domainonly = str_replace('www.', '', $currentdomain);
        $domainonly = str_replace('https://', '', $domainonly);
        $domainonly = str_replace('http://', '', $domainonly);
        $domainonly = str_replace('/moodle', '', $domainonly);
        $email = 'no-reply@'.$domainonly;
        $name = $domainonly;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ada.skynettechnologies.us/api/add-user-domain',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('name' => $name, 'email' => $email, 'company_name' => $currentdomain, 'website' => base64_encode($currentdomain), 'package_type' => 'free-widget',
                'start_date' => date('Y-m-d H:i:s'), 'end_date' => '', 'price' => '0', 'discount_price' => '0', 'plaform' => 'Moodle', 'api_key' => '', 'is_trial_period' => '0',
                'is_free_widget' => '1', 'bill_address' => '', 'country' => '', 'state' => '', 'city' => '', 'post_code' => '', 'transaction_id' => '', 'subscr_id' => '', 'payment_source' => ''),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return true;
    }
    return true;
}
