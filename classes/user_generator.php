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


class user_generator {

    private static $default_size = 1;
    private $generator = '';


    public function create_users($size) {
        global $DB;
        if(empty($size)) {
            $size = $this->default_size;
        }

        $lastid = $DB->get_record_select('user', '', null, 'max(id)');
        $lastid = (int)$lastid->max;

        $this->create_user_accounts($size, $lastid);
    }


    private function create_user_accounts($size, $nextid) {
        global $CFG;

        $file = fopen("data/userlist.csv","r");
        $firstname = array();
        $lastname = array();
        while($row = fgetcsv($file)) {
            $firstname[] = trim($row[0]);
            $lastname[] = trim($row[1]);
        }
        array_shift($firstname);
        array_shift($lastname);

        for ($number=0; $number <= $size; $number++) {
            $nextid++;

            $fname = $firstname[rand(0,99)];
            $lname = $lastname[rand(0,99)];
            $username = "{$fname}_{$lname}_{$nextid}";
            // Create user account.
            $record = array(
                'username' => strtolower($username),
                'id'=> $nextid,
                'firstname' => $fname,
                'lastname' => $lname,
                'email' => strtolower($username).'@catalyst.co.nz'
                );

            // We add a user password if it has been specified.
            if (!empty($CFG->tool_generator_users_password)) {
                $record['password'] = $CFG->tool_generator_users_password;
            }
            require_once($CFG->dirroot . '/lib/phpunit/classes/util.php');
            $this->generator = phpunit_util::get_data_generator();
            $user = $this->generator->create_user($record);
        }
        echo html_writer::div(get_string('endcreating', 'local_minimoodle'));
    }
}
