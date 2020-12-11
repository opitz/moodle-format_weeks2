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
 * Updating the course format options with a new sequence in which the tabs are displayed
 *
 * @package    format_weeks2
 * @copyright  2020 Matthias Opitz
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('../../../../config.php');
require_login();

/**
 * Update the name of a given tab
 *
 * @param $courseid
 * @param $tabid
 * @param $tabname
 * @return string
 * @throws coding_exception
 * @throws dml_exception
 */
function update_tab_name($courseid, $tabid, $tabname) {
    global $DB;

    $context = context_course::instance($courseid);

    if (has_capability('moodle/course:update', $context)) {
        $formatoptions = $DB->get_records('course_format_options', array('courseid' => $courseid));
        foreach ($formatoptions as $option) {
            if ($option->name == $tabid . '_title' && $option->value !== $tabname) {
                $option->value = $tabname;
                $DB->update_record('course_format_options', $option);
                return $option->id;
            }
        }
    }
    return '';
}


echo update_tab_name($_POST['courseid'], $_POST['tabid'], $_POST['tab_name']);