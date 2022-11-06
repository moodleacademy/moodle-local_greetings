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

namespace local_greetings\external;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->libdir . "/externallib.php");

use external_api;
use external_description;
use external_function_parameters;
use external_single_structure;
use external_value;
use external_warnings;
use stdClass;

/**
 * Add message.
 *
 * @package     local_greetings
 * @copyright   2022 Moodle Pty Ltd. (http://moodle.com)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class add_message extends external_api {

    /**
     * Returns the description of the webservice parameters.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'message' => new external_value(PARAM_RAW, 'Greeting message'),
        ]);
    }

    /**
     * Handle request.
     *
     * @param  string $message Greeting message.
     * @return array Result as defined in execute_returns.
     */
    public static function execute($message) {
        // Validate request.
        $validatedparams = self::validate_parameters(self::execute_parameters(), compact('message'));
        [$message] = array_values($validatedparams);

        $message = trim($message);

        if (empty($message)) {
            return [
                'warnings' => [[
                    'warningcode' => 'emptymessage',
                    'message' => get_string('emptymessage', 'local_greetings')
                ]],
            ];
        }

        // Add message.
        global $DB, $USER;

        $record = new stdClass();
        $record->message = $message;
        $record->timecreated = time();
        $record->userid = $USER->id;

        $DB->insert_record('local_greetings_messages', $record);

        return ['warnings' => []];
    }

    /**
     * Returns the description of the webservice response.
     *
     * @return external_description
     */
    public static function execute_returns(): external_description {
        return new external_single_structure([
            'warnings' => new external_warnings(),
        ]);
    }

}
