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
 * @copyright  2024 Rajesh Bhimani <developer3@skynettechnologies.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Render the setting for widget.
 *
 * @return void
 */
function local_allinoneaccessibility_before_standard_html_head() {
    global $PAGE;
    global $CFG;
    $widgetsettingada = get_config('local_allinoneaccessibility');
    $color = '0678be';
    $color = trim(str_replace('#', '', $color));
    $token = '';
    $iconposition = '';
    $iconsize = 'aioa-default-icon';
    $icontype = 'aioa-icon-type-1';
    $time = rand(0, 10);
    $currentdomain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '-';
    $excludepages = ['admin', 'embedded', 'frametop', 'maintenance', 'popup', 'print', 'redirect', 'report'];
    $licensekeymessage = get_string('aioa-licensekeydesc', 'local_allinoneaccessibility');
    $upgrademessage = get_string('aioa-upgrade', 'local_allinoneaccessibility');
    if (!in_array($PAGE->pagelayout, $excludepages)) {
        $requestparam = 'colorcode=#' . $color . '&token=' . $token . '&t=' .
            $time . '&position=' . $iconposition . '.' . $icontype . '.' . $iconsize;
        $script = "<script id='aioa-adawidget' src='https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility";
        $script .= "-js-widget-minify.js?$requestparam'></script>";
        echo $script;
    } else if ($PAGE->pagelayout == 'admin') {
        $currenturl = new moodle_url($PAGE->url);
        $section = $currenturl->get_param('section', '');
        if ($section == 'local_allinoneaccessibility') {
            $baseurl = $CFG->wwwroot;
            $arrregresponse = local_allinoneaccessibility_register_domain($baseurl);
            include(__DIR__ . '/iparams.php');
            echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>';
        }
    }
}

/**
 * Upgrade script for local_allinoneaccessibility.
 *
 * @param int $oldversion
 * @return bool
 */
function local_allinoneaccessibility_upgrade($oldversion) {
    if ($oldversion < 2025121824) {
        local_allinoneaccessibility_before_standard_html_head();
    }
    return true;
}

/**
 * Executes a request to the given API and returns the response.
 *
 * This function sends a request to an external API with the specified data
 * and processes the response, returning the result as an associative array.
 *
 * @param string $apiurl The URL of the API to which the request is sent. This should be a fully qualified URL.
 * @param array $data The data to send in the request body. Typically, this is an associative array of key-value pairs.
 * @return array The response from the API, usually in JSON format, as an associative array.
 */
function local_allinoneaccessibility_execute_request($apiurl, $data) {
    global $CFG;
    require_once($CFG->libdir . '/filelib.php');
    $curl = new curl();
    $adaapiurl = 'https://ada.skynettechnologies.us/api/' . $apiurl;
    $postdata = http_build_query($data);
    $options = ['CURLOPT_RETURNTRANSFER' => true,
        'CURLOPT_POST' => true,
        'CURLOPT_POSTFIELDS' => $postdata];
    $response = $curl->post($adaapiurl, $data, $options);
    if ($response === false) {
        return [];
    } else {
        // Decode the response JSON and return it as an associative array.
        return json_decode($response, true);
    }
}

/**
 * Registers a domain with the external system.
 *
 * @param string $currentdomain The domain name to register.
 * @return bool Returns `true` if the registration is successful, `false` otherwise.
 */
function local_allinoneaccessibility_register_domain($currentdomain) {
    global $CFG;
    require_once($CFG->libdir . '/filelib.php');
    $encodeddomain = base64_encode($currentdomain);
    $data = [
        'website' => $encodeddomain,
    ];
    $apiurl = 'get-autologin-link-new';
    $responsearr = local_allinoneaccessibility_execute_request($apiurl, $data);
    if (!isset($responsearr['status']) || (isset($responsearr['status']) && $responsearr['status'] == 0)) {
        $domainonly = str_replace('www.', '', $currentdomain);
        $domainonly = str_replace('https://', '', $domainonly);
        $domainonly = str_replace('http://', '', $domainonly);
        $domainonly = str_replace('/moodle', '', $domainonly);
        $email = 'no-reply@' . $domainonly;
        $name = $domainonly;
        $options = ['CURLOPT_RETURNTRANSFER' => true, 'CURLOPT_ENCODING' => '',
            'CURLOPT_MAXREDIRS' => 10, 'CURLOPT_TIMEOUT' => 0,
            'CURLOPT_FOLLOWLOCATION' => true,
            'CURLOPT_HTTP_VERSION' => CURL_HTTP_VERSION_1_1];
        $eucurl = new curl();
        $norequiredeu = 1;
        $euresponsertring = $eucurl->post('https://ipapi.co/json/', [], $options);
        if ($euresponsertring) {
            $euresponse = json_decode($euresponsestring, true);
            if (isset($euresponse['in_eu']) && $euresponse['in_eu']) {
                $norequiredeu = 0;
            }
        }
        $curl = new curl();
        $url = 'https://ada.skynettechnologies.us/api/add-user-domain';
        $postdata = [ 'name' => $name, 'email' => $email, 'company_name' => $currentdomain,
            'website' => base64_encode($currentdomain), 'package_type' => 'free-widget',
            'start_date' => date('Y-m-d H:i:s'), 'end_date' => '', 'price' => '0',
            'discount_price' => '0', 'platform' => 'Moodle', 'api_key' => '', 'is_trial_period' => '0',
            'is_free_widget' => '1', 'bill_address' => '', 'country' => '', 'state' => '', 'city' => '',
            'post_code' => '', 'transaction_id' => '', 'subscr_id' => '', 'payment_source' => '',
            'no_required_eu' => $norequiredeu];
        $response = $curl->post($url, $postdata, $options);
        return true;
    }
    return true;
}
