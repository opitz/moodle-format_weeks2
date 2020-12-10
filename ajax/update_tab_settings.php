<?php
/**
 * Created by PhpStorm.
 * User: opitz
 * Date: 2019-09-20
 *
 * Updating the course format options for a tab
 */
require_once('../../../../config.php');

/**
 * Update the tab settings in the course format options table
 *
 * @param $courseid
 * @param $tabid
 * @param $sections
 * @param $sectionnums
 * @return string
 * @throws coding_exception
 * @throws dml_exception
 */
function update_tab_settings($courseid, $tabid, $sections, $sectionnums)
{
    global $DB;

    $context = context_course::instance($courseid);

    if (has_capability('moodle/course:update', $context)) {
        // save the sections of the tab
        $format_option = $DB->get_record('course_format_options', array('courseid' => $courseid, 'name' => $tabid));
        if(isset($format_option) && $format_option) {
            $format_option->value = $sections;
            $DB->update_record('course_format_options', $format_option);
        }
        // save the sectionnums of the tab
        $format_option = $DB->get_record('course_format_options', array('courseid' => $courseid, 'name' => $tabid.'_sectionnums'));
        if(isset($format_option) && $format_option) {
            $format_option->value = $sectionnums;
            $DB->update_record('course_format_options', $format_option);
        }
    }
    return 'ok';
}


echo update_tab_settings($_POST['courseid'], $_POST['tabid'], $_POST['sections'], $_POST['sectionnums']);