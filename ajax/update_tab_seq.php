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
 * Save the order of the tabs in a course to the database
 *
 * @param int $courseid
 * @param string $tabseq
 * @param string $formatname
 * @return mixed
 */
function update_tab_seq($courseid, $tabseq, $formatname) {
    global $DB;

    if ($DB->record_exists('course_format_options', array('courseid' => $courseid, 'name' => 'tab_seq'))) {
        $tabseqrecord = $DB->get_record('course_format_options', array('courseid' => $courseid, 'name' => 'tab_seq'));
        $tabseqrecord->value = $tabseq;
        $DB->update_record('course_format_options', $tabseqrecord);
    } else {
        $tabseqrecord = new \stdClass();
        $tabseqrecord->courseid = $courseid;
        $tabseqrecord->format = $formatname;
        $tabseqrecord->sectionid = 0;
        $tabseqrecord->name = 'tab_seq';
        $tabseqrecord->value = $tabseq;
        $DB->insert_record('course_format_options', $tabseqrecord);
    }
    return $tabseq;
}

require_sesskey();

$courseid = required_param('courseid', PARAM_INT);
$tabseq = required_param('tab_seq', PARAM_RAW);
$formatname = required_param('course_format_name', PARAM_RAW);

if (!isset($tabseq) || count($tabseq) === 0) {
    exit;
}

echo update_tab_seq($courseid, $tabseq, $formatname);
