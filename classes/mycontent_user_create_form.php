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


defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

class minimoodle_user_create_form extends moodleform {
    private static $default_size = 10;

    public function definition() {
        $mform = $this->_form;
        $mform->addElement('select', 'size', get_string('noofusers', 'local_minimoodle'), 
                $this->get_size_choices());
        $mform->setDefault('size', self::$default_size);
        $mform->addElement('submit', 'submit', get_string('createuserbtn', 'local_minimoodle'));
    }

    private function get_size_choices() {
        $options = array(
            '10' => get_string('user10', 'local_minimoodle'),
            '50' => get_string('user50', 'local_minimoodle'),
            '100' => get_string('user100', 'local_minimoodle'),
            '500' => get_string('user500', 'local_minimoodle'),
            '1000' => get_string('user1000', 'local_minimoodle')
        );
        return $options;
    }

    public function validation($data, $files) {
        global $DB;
        $errors = array();

        if(!empty($data['size'])) {
            $error = 'The size not recognized by the system';
            $errors['size'] = $error;
        }
    }
}
