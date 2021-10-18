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
 * Updating the course format options for a tab
 *
 * @package    format_weeks2
 * @copyright  2020 Matthias Opitz
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('../../../../config.php');
require_login();

/**
 * Update the tab settings in the course format options table
 *
 * @param int $courseid
 * @param int $tabid
 * @param stdClass $sections
 * @param string $sectionnums
 * @return string
 * @throws coding_exception
 * @throws dml_exception
 */
function update_tab_settings($courseid, $tabid, $sections, $sectionnums) {
    global $DB;

    $context = context_course::instance($courseid);

    if (has_capability('moodle/course:update', $context)) {
        // Save the sections of the tab.
        $formatoption = $DB->get_record('course_format_options', array('courseid' => $courseid, 'name' => $tabid));
        if (isset($formatoption) && $formatoption) {
            $formatoption->value = $sections;
            $DB->update_record('course_format_options', $formatoption);
        }
        // Save the sectionnums of the tab.
        $formatoption = $DB->get_record('course_format_options', array('courseid' => $courseid, 'name' => $tabid.'_sectionnums'));
        if (isset($formatoption) && $formatoption) {
            $formatoption->value = $sectionnums;
            $DB->update_record('course_format_options', $formatoption);
        }
    }
    return 'ok';
}


echo update_tab_settings($_POST['courseid'], $_POST['tabid'], $_POST['sections'], $_POST['sectionnums']);
