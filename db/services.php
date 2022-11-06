<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * @package     local_greetings
 * @copyright   2022 Moodle Pty Ltd. (http://moodle.com)
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$functions = [
    'local_greetings_add_message' => [
        'classname'     => 'local_greetings\external\add_message',
        'methodname'    => 'execute',
        'classpath'     => 'local/greetings/classes/external/add_message.php',
        'description'   => 'Submit new message',
        'type'          => 'write',
        'capabilities'  => 'local/greetings:postmessages',
        'services'      => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
];
