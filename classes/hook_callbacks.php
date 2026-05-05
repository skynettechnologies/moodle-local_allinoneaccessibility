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
 * Plugin hook callbacks details
 * @package local_allinoneaccessibility
 * @copyright  2024 Rajesh Bhimani <developer3@skynettechnologies.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_allinoneaccessibility;

/**
 * Hook callbacks for the All in One Accessibility.
 */
class hook_callbacks {
    /**
     * Inject JS before </head>
     *
     * @param \core\hook\output\before_standard_head_html_generation $hook
     */
    public static function before_standard_head_html_generation(
        \core\hook\output\before_standard_head_html_generation $hook
    ) {
        global $PAGE;
        if (!isset($PAGE)) {
            return;
        }
        $excludepages = ['admin', 'embedded', 'frametop', 'maintenance', 'popup', 'print', 'redirect', 'report'];
        if (in_array($PAGE->pagelayout, $excludepages)) {
            return;
        }
        $widgetsettingada = get_config('local_allinoneaccessibility');
        $color = isset($widgetsettingada->colorcode) ? $widgetsettingada->colorcode : '0678be';
        $color = trim(str_replace('#', '', $color));
        $token = $widgetsettingada->licensekey ?? '';
        $iconposition = $widgetsettingada->iconposition ?? '';
        $iconsize = $widgetsettingada->iconsize ?? 'aioa-default-icon';
        $icontype = $widgetsettingada->icontype ?? 'aioa-icon-type-1';
        $time = rand(0, 10);
        $param = 'colorcode=#' . $color .
                '&token=' . $token .
                '&t=' . $time .
                '&position=' . $iconposition . '.' . $icontype . '.' . $iconsize;
        $url = 'https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?' . $param;
        $hook->add_html('<script id="aioa-adawidget" src="' . $url . '"></script>');
    }
}
