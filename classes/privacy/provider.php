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

namespace local_allinoneaccessibility\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\writer;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\approved_contextlist;

/**
 * Privacy provider for local_allinoneaccessibility plugin.
 */
class provider implements
    \core_privacy\local\metadata\provider,
    \core_privacy\local\request\plugin\provider {
    /**
     * Returns meta data about this system.
     *
     * @param   collection $collection The initialised collection to add items to.
     * @return  collection     A listing of user data stored through this system.
     */
    public static function get_metadata(collection $collection): collection {
        $collection->add_database_table(
            'local_allinoneaccessibility',
            [
                'userid' => 'privacy:metadata:domain_client:userid',
                'email' => 'privacy:metadata:domain_client:email',
                'name' => 'privacy:metadata:domain_client:name',
                'website' => 'privacy:metadata:domain_client:website',
            ],
            'privacy:metadata'
        );
        return $collection;
    }
    /**
     * Get the list of contexts that contain user information for the specified user.
     *
     * @param   int $userid The user to search.
     * @return  contextlist   $contextlist  The contextlist containing the list of contexts used in this plugin.
     */
    public static function get_contexts_for_userid(int $userid): contextlist {
        $contextlist = new contextlist();
        global $DB;
        $records = $DB->get_records('local_allinoneaccessibility', ['userid' => $userid]);
        if (!empty($records)) {
            $contextlist->add_system_context();
        }
        return $contextlist;
    }
    /**
     * Export all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts to export information for.
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        global $DB;
        $userid = $contextlist->get_user()->id;
        $records = $DB->get_records('local_allinoneaccessibility', ['userid' => $userid]);
        foreach ($records as $record) {
            $context = \context_system::instance();
            writer::with_context($context)->export_data(
                [],
                (object)[
                    'email' => $record->email,
                    'name' => $record->name,
                    'website' => $record->website,
                ]
            );
        }
    }
    /**
     * Delete all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts and user information to delete information for.
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        global $DB;
        if (empty($contextlist->count())) {
            return;
        }
        $userid = $contextlist->get_user()->id;
        $DB->delete_records('local_allinoneaccessibility', ['userid' => $userid]);
    }
    /**
     * Delete all data for all users in the specified context.
     *
     * @param context $context The specific context to delete data for.
     */
    public static function delete_data_for_all_users_in_context(\context $context) {
        global $DB;
        if ($context->contextlevel == CONTEXT_SYSTEM) {
            $DB->delete_records('local_allinoneaccessibility');
        }
    }
    /**
     * Returns the link to the external location where user data is sent.
     *
     * @return string The external location URL where the data is sent.
     */
    public static function get_external_location_link() {
        return 'https://ada.skynettechnologies.us';
    }
}
