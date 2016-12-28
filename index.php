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
 * My content generator
 *
 * @package    local_minimoodle
 * @copyright  2016 Pramith Dayananda - pramithkm@gmail.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $PAGE, $DB;
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once($CFG->dirroot.'/local/minimoodle/lib.php');
require_once($CFG->dirroot.'/local/minimoodle/classes/user_generator.php');
require_once($CFG->dirroot.'/local/minimoodle/classes/minimoodle_user_create_form.php');

$strname = get_string('title', 'local_minimoodle');

$PAGE->set_url('/mod/newmodule/index.php');
$PAGE->navbar->add($strname);
$PAGE->set_pagelayout('standard');
$PAGE->set_context(context_system::instance());

echo $OUTPUT->header();
echo $OUTPUT->heading($strname);

$data = new user_generator();
// Set up the form.
$mform = new minimoodle_user_create_form();
if ($data = $mform->get_data()) {
    $usergen = new user_generator();
    //var_dump($data->size);
    $usergen->create_users($data->size);
} else {
    // Display form.
    $mform->display();
}

echo html_writer::link($CFG->wwwroot.'/local/minimoodle/frontpage.php','Change Site Information')."<br>";
echo html_writer::link($CFG->wwwroot.'/local/minimoodle/usercreate.php', 'Create sample users');

echo $OUTPUT->footer();
