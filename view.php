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
 * GoToMeeting module view
 * @package mod_gotomeeting
 * @copyright 2017 Alok Kumar Rai <alokr.mail@gmail.com,alokkumarrai@outlook.in>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require('../../config.php');
require_once($CFG->dirroot . '/mod/gotomeeting/locallib.php');
require_once($CFG->dirroot . '/mod/gotomeeting/lib/OSD.php');
require_once($CFG->libdir . '/completionlib.php');
$id = required_param('id', PARAM_INT); // Course Module ID

if ($id && !$cm = get_coursemodule_from_id('gotomeeting', $id)) {
    print_error('invalidcoursemodule');
}

$gotomeeting = $DB->get_record('gotomeeting', ['id' => $cm->instance], '*', MUST_EXIST);
$course = $DB->get_record('course', ['id' => $cm->course], '*', MUST_EXIST);
$gotomeeting_joinurl = get_gotomeeting($gotomeeting);
$meeturl = $gotomeeting;
$meetinginfo = json_decode($gotomeeting->meetinfo);


require_course_login($course, true, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/gotomeeting:view', $context);


$PAGE->set_url('/mod/gotomeeting/view.php', ['id' => $cm->id]);
$PAGE->set_title($course->shortname . ': ' . $gotomeeting->name);
$PAGE->set_heading($course->fullname);
$completion = new completion_info($course);
$completion->set_module_viewed($cm);

echo $OUTPUT->header();
echo $OUTPUT->heading('Course:  ' . $course->fullname);

$table = new html_table();
$table->head = [get_string('pluginname', 'mod_gotomeeting')];
$table->headspan = [2];
$table->size = ['30%', '70%'];

$cell1 = new html_table_cell(get_string('meetingtitle', 'mod_gotomeeting'));
$cell1->colspan = 1;
$cell1->style = 'text-align:left;';

$cell2 = new html_table_cell("<b>" . $gotomeeting->name . "</b>");
$cell2->colspan = 1;
$cell2->style = 'text-align:left;';
$table->data[] = [$cell1, $cell2];

$cell1 = new html_table_cell(get_string('meetingdescription', 'mod_gotomeeting'));
$cell1->colspan = 1;
$cell1->style = 'text-align:left;';

$cell2 = new html_table_cell("<b>" . strip_tags($gotomeeting->intro) . "</b>");
$cell2->colspan = 1;
$cell2->style = 'text-align:left;';

$table->data[] = [$cell1, $cell2];


$cell1 = new html_table_cell(get_string('meetingstartenddate', 'mod_gotomeeting'));
$cell1->colspan = 1;
$cell1->style = 'text-align:left;';

$cell2 = new html_table_cell("<b>" . userdate($gotomeeting->startdatetime) . "</b>");
$cell2->colspan = 1;
$cell2->style = 'text-align:left;';

$table->data[] = [$cell1, $cell2];


$cell1 = new html_table_cell(get_string('meetingenddateandtime', 'mod_gotomeeting'));
$cell1->colspan = 1;
$cell1->style = 'text-align:left;';

$cell2 = new html_table_cell("<b>" . userdate($gotomeeting->enddatetime) . "</b>");
$cell2->colspan = 1;
$cell2->style = 'text-align:left;';

$table->data[] = [$cell1, $cell2];

$cell2 = new html_table_cell(html_writer::link(trim($gotomeeting_joinurl, '"'),
    get_string('joinmeeting', 'mod_gotomeeting'), ["target" => "_blank", 'class' => 'btn btn-primary']));
$cell2->colspan = 2;
$cell2->style = 'text-align:center;';

$table->data[] = [$cell2];


echo html_writer::table($table);


echo $OUTPUT->footer();
