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
 * Edit greetings
 *
 * @package     local_greetings
 * @copyright   2022 Your name <your@email>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot . '/local/greetings/lib.php');

$context = context_system::instance();

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/greetings/index.php'));
$PAGE->set_pagelayout('standard');
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading(get_string('editmessage', 'local_greetings'));

require_login();

if (isguestuser()) {
    throw new moodle_exception('noguest');
}

$id = required_param('id', PARAM_INT);

// Get record greeting from database.
if (!$result = $DB->get_record('local_greetings_messages', ['id' => $id])) {
    throw new moodle_exception('norecordfound', 'local_greetings');
}

// Just using the delete capability check.
$canedit = has_capability('local/greetings:deleteanymessage', $context) ||
    (has_capability('local/greetings:deleteownmessage', $context) && $result->userid == $USER->id);

$messageform = new \local_greetings\form\message_form(null, ['message' => $result]);

if ($canedit && $data = $messageform->get_data()) {
    $message = required_param('message', PARAM_TEXT);

    if (!empty($message)) {
        // Only update the message. Leave other data untouched.
        $result->message = $message;

        $DB->update_record('local_greetings_messages', $result);

        redirect($PAGE->url); // Go to main greetings page.
    }
}

echo $OUTPUT->header();

if ($canedit) {
    $messageform->display();
} else {
    throw new moodle_exception('cannoteditmessage', 'local_greetings');
}

echo $OUTPUT->footer();
