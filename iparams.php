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
 * Privacy Subsystem implementation for local_allinoneaccessibility.
 *
 * @package local_allinoneaccessibility
 * @copyright  2024 Rajesh Bhimani <developer3@skynettechnologies.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

require_once($CFG->libdir . '/adminlib.php');

admin_externalpage_setup('local_allinoneaccessibility');

global $CFG, $OUTPUT;

$PAGE->requires->jquery();
$PAGE->requires->js_call_amd(
    'local_allinoneaccessibility/iparams',
    'init'
);

$isconfirmed = get_config('local_allinoneaccessibility', 'registrationconfirmed');

$templatecontext = [
    'positions' => [
        [
            'value' => 'top_left',
            'label' => get_string('aioa-top_left', 'local_allinoneaccessibility'),
            'checked' => false,
        ],
        [
            'value' => 'top_center',
            'label' => get_string('aioa-top_center', 'local_allinoneaccessibility'),
            'checked' => false,
        ],
        [
            'value' => 'top_right',
            'label' => get_string('aioa-top_right', 'local_allinoneaccessibility'),
            'checked' => false,
        ],
        [
            'value' => 'middel_left',
            'label' => get_string('aioa-middel_left', 'local_allinoneaccessibility'),
            'checked' => false,
        ],
        [
            'value' => 'middel_right',
            'label' => get_string('aioa-middel_right', 'local_allinoneaccessibility'),
            'checked' => false,
        ],
        [
            'value' => 'bottom_left',
            'label' => get_string('aioa-bottom_left', 'local_allinoneaccessibility'),
            'checked' => false,
        ],
        [
            'value' => 'bottom_center',
            'label' => get_string('aioa-bottom_center', 'local_allinoneaccessibility'),
            'checked' => false,
        ],
        [
            'value' => 'bottom_right',
            'label' => get_string('aioa-bottom_right', 'local_allinoneaccessibility'),
            'checked' => true,
        ],
    ],
    'icon_types' => array_map(function ($i) {
        return [
            'value' => $i,
            'label' => get_string('position', 'local_allinoneaccessibility', $i),
            'image' => 'https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-' . $i . '.svg',
            'checked' => ($i == 1) ? true : false,
        ];
    }, range(1, 29)),
    'custom_size_toggle_title' => get_string('aioa-custom-size-toggle', 'local_allinoneaccessibility'),
    'custom_size_label'        => get_string('aioa-custom-size-lable', 'local_allinoneaccessibility'),
    'select_exact_size_label'  => get_string('aioa-select-exact-size', 'local_allinoneaccessibility'),
    'select_exact_size_desc'   => get_string('aioa-select-exact-size-desc', 'local_allinoneaccessibility'),
    'px_label'                 => get_string('aioa-px-label', 'local_allinoneaccessibility'),
    'widget_icon_size_custom'  => '',
    'select_icon_size_desktop_label' => get_string('aioa-select-icon-size-desktop', 'local_allinoneaccessibility'),
    'icon_sizes' => [
        [
            'id'      => 'edit-size-big',
            'value'   => 'aioa-big-icon',
            'label'   => get_string('aioa-big-icon', 'local_allinoneaccessibility'),
            'size'    => 75,
            'image'   => 'https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-1.svg',
            'checked' => false,
        ],
        [
            'id'      => 'edit-size-medium',
            'value'   => 'aioa-medium-icon',
            'label'   => get_string('aioa-medium-icon', 'local_allinoneaccessibility'),
            'size'    => 65,
            'image'   => 'https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-1.svg',
            'checked' => true,
        ],
        [
            'id'      => 'edit-size-default',
            'value'   => 'aioa-default-icon',
            'label'   => get_string('aioa-default-icon', 'local_allinoneaccessibility'),
            'size'    => 55,
            'image'   => 'https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-1.svg',
            'checked' => false,
        ],
        [
            'id'      => 'edit-size-small',
            'value'   => 'aioa-small-icon',
            'label'   => get_string('aioa-small-icon', 'local_allinoneaccessibility'),
            'size'    => 45,
            'image'   => 'https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-1.svg',
            'checked' => false,
        ],
        [
            'id'      => 'edit-size-extra-small',
            'value'   => 'aioa-extra-small-icon',
            'label'   => get_string('aioa-extra-small-icon', 'local_allinoneaccessibility'),
            'size'    => 35,
            'image'   => 'https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-1.svg',
            'checked' => false,
        ],
    ],
    'isconfirmed' => $isconfirmed,
];

echo $OUTPUT->header();
echo $OUTPUT->render_from_template(
    'local_allinoneaccessibility/iparams',
    $templatecontext
);
echo $OUTPUT->footer();
