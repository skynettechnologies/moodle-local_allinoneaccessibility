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
    $color = '0678be';
    $token = '';
    $iconposition = '';
    $iconsize = 'aioa-default-icon';
    $icontype = 'aioa-icon-type-1';
    $time = rand(0, 10);
    $excludepages = ['admin', 'embedded', 'frametop', 'maintenance', 'popup', 'print', 'redirect', 'report'];
    if (!in_array($PAGE->pagelayout, $excludepages)) {
        $requestparam = 'colorcode=#' . $color . '&token=' . $token . '&t=' .
            $time . '&position=' . $iconposition . '.' . $icontype . '.' . $iconsize;
        $script = "<script id='aioa-adawidget' src='https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility";
        $script .= "-js-widget-minify.js?$requestparam'></script>";
        echo $script;
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
