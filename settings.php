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
 * Settings definition
 *
 * @package     local_allinoneaccessibility
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    // Settings will be NULL.
    $settings = new admin_settingpage('local_allinoneaccessibility', get_string('pluginname', 'local_allinoneaccessibility'));
    
    $ADMIN->add('localplugins', $settings);
    
    $settings->add(
        new admin_setting_configselect(
            'local_allinoneaccessibility/isenabled',
            get_string('aioa-is_enabled', 'local_allinoneaccessibility'),
            '',
            'yes',
            ['yes'=>get_string('aioa-yes', 'local_allinoneaccessibility'),
                'no'=>get_string('aioa-no', 'local_allinoneaccessibility')]
        )
    );
    
    $settings->add(
        new admin_setting_configtext(
            'local_allinoneaccessibility/licensekey',
            get_string('aioa-licensekey', 'local_allinoneaccessibility'),
            get_string('aioa-licensekeydesc', 'local_allinoneaccessibility'),
            ''
        )
    );
    
    
    $settings->add(
        new admin_setting_configtext(
            'local_allinoneaccessibility/colorcode',
            get_string('aioa-colorcode', 'local_allinoneaccessibility'),
            get_string('aioa-colorcodedesc', 'local_allinoneaccessibility'),
            '6F42C1'
        )
    );
    
    $settings->add(
        new admin_setting_configselect(
            'local_allinoneaccessibility/iconposition',
            get_string('aioa-iconposition', 'local_allinoneaccessibility'),
            '',
            'bottom_right',
            ['top_left'=>get_string('aioa-top_left', 'local_allinoneaccessibility'),
                'top_center'=>get_string('aioa-top_center', 'local_allinoneaccessibility'),
                'top_right'=>get_string('aioa-top_right', 'local_allinoneaccessibility'),
                'middel_left'=>get_string('aioa-middel_left', 'local_allinoneaccessibility'),
            'middel_right'=>get_string('aioa-middel_right', 'local_allinoneaccessibility'),
    'bottom_left'=>get_string('aioa-bottom_left', 'local_allinoneaccessibility'),
    'bottom_center'=>get_string('aioa-bottom_center', 'local_allinoneaccessibility'),
    'bottom_right'=>get_string('aioa-bottom_right', 'local_allinoneaccessibility')]
        )
    );
    
    $settings->add(
        new admin_setting_configselect(
            'local_allinoneaccessibility/iconsize',
            get_string('aioa-iconsize', 'local_allinoneaccessibility'),
            '',
            'aioa-default-icon',
            ['aioa-big-icon'=>get_string('aioa-big-icon', 'local_allinoneaccessibility'),
                'aioa-medium-icon'=>get_string('aioa-medium-icon', 'local_allinoneaccessibility'),
                'aioa-default-icon'=>get_string('aioa-default-icon', 'local_allinoneaccessibility'),
                'aioa-small-icon'=>get_string('aioa-small-icon', 'local_allinoneaccessibility'),
                'aioa-extra-small-icon'=>get_string('aioa-extra-small-icon', 'local_allinoneaccessibility')]
        )
    );
    
    $settings->add(
        new admin_setting_configselect(
            'local_allinoneaccessibility/icontype',
            get_string('aioa-icontype', 'local_allinoneaccessibility'),
            get_string('aioa-icontypedesc', 'local_allinoneaccessibility'),
            'aioa-icon-type-1',
            ['aioa-icon-type-1'=>get_string('aioa-icon-type-1', 'local_allinoneaccessibility'),
                'aioa-icon-type-2'=>get_string('aioa-icon-type-2', 'local_allinoneaccessibility'),
                'aioa-icon-type-3'=>get_string('aioa-icon-type-3', 'local_allinoneaccessibility')]
        )
    );
}
