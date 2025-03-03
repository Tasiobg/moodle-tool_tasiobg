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
 * TODO describe file edit
 *
 * @package    tool_tasiobg
 * @copyright  2025 Tasio Bertomeu Gomez <tasio.bertomeu@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../../config.php');

require_login();

$url = new moodle_url('/admin/tool/tasiobg/edit.php', []);
$PAGE->set_url($url);
$PAGE->set_context(context_system::instance());
require_capability('tool/tasiobg:edit', $PAGE->context);

$courseid = optional_param('courseid', 0, PARAM_INT);
$entryid = optional_param('entryid', 0, PARAM_INT);
$delete = optional_param('delete', 0, PARAM_INT);
$textfieldoptions = [
    'trusttext' => true,
    'subdirs' => true,
    'maxfiles' => 99,
    'maxbytes' => get_config('moodlecourse', 'maxbytes'),
    'context' => $PAGE->context,
];

if ($delete > 0) {
    require_sesskey();
    $course = $DB->get_record('tool_tasiobg', ['id' => $delete], '*', MUST_EXIST);
    $DB->delete_records('tool_tasiobg', ['id' => $delete]);
    redirect(new moodle_url('/admin/tool/tasiobg/index.php', ['id' => $course->courseid]));
}

// Instantiate the myform form from within the plugin.
$mform = new \tool_tasiobg\form\tool_tasiobg_form(null, ['courseid' => $courseid, 'entryid' => $entryid]);

// Form processing and displaying is done here.
if ($mform->is_cancelled()) {
    // If there is a cancel element on the form, and it was pressed,
    // then the `is_cancelled()` function will return true.
    redirect(new moodle_url('/admin/tool/tasiobg/index.php', ['id' => $courseid]));
} else if ($fromform = $mform->get_data()) {
    // When the form is submitted, and the data is successfully validated,
    // the `get_data()` function will return the data posted in the form.

    if ($fromform->entryid > 0) {
        $course = $DB->get_record('tool_tasiobg', ['id' => $fromform->entryid], '*', MUST_EXIST);
        $course->name = trim($fromform->name);
        $course->completed = (property_exists($fromform, 'completed') && $fromform->completed === '1') ? 1 : 0;
        $course->timemodified = time();
        $course->description_editor = $fromform->description_editor;
        $course = file_postupdate_standard_editor(
            $course, 'description', $textfieldoptions, $PAGE->context, 'tool_tasiobg', 'tool_tasiobg',
            $course->id);
        $DB->update_record('tool_tasiobg', $course);
        $courseid = $course->courseid;
    } else if ($fromform->courseid > 0) {
        $newrow = new stdClass();
        $newrow->courseid = $fromform->courseid;
        $newrow->name = trim($fromform->name);
        $newrow->completed = (property_exists($fromform, 'completed') && $fromform->completed === '1') ? 1 : 0;
        $newrow->timecreated = time();
        $newrow->timemodified = $newrow->timecreated;
        $newrow->id = $DB->insert_record('tool_tasiobg', $newrow);
        $newrow->description_editor = $fromform->description_editor;
        $newrow = file_postupdate_standard_editor(
            $newrow, 'description', $textfieldoptions, $PAGE->context, 'tool_tasiobg', 'tool_tasiobg',
            $newrow->id);
        $DB->update_record('tool_tasiobg', $newrow);
    }
    redirect(new moodle_url('/admin/tool/tasiobg/index.php', ['id' => $courseid]));
}

$PAGE->set_heading($SITE->fullname);
echo $OUTPUT->header();

// If we are editing an existing entry, display the data.
if (!isset($fromform) || !property_exists($fromform, 'entryid') || $fromform->entryid == 0) {
    if ($entryid > 0) {
        $course = $DB->get_record('tool_tasiobg', ['id' => $entryid], '*', MUST_EXIST);
        $course = file_prepare_standard_editor(
            $course, 'description', $textfieldoptions, $PAGE->context, 'tool_tasiobg', 'tool_tasiobg', $course->id
        );
        $mform->set_data($course);
    }
}

// Display the form.
$mform->display();

echo $OUTPUT->footer();
