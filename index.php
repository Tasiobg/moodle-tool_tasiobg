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
 * TODO describe file index
 *
 * @package    tool_tasiobg
 * @copyright  2025 Tasio Bertomeu Gomez <tasio.bertomeu@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');
require_once($CFG->libdir.'/adminlib.php');

require_login();

$title = get_string('pluginname', 'tool_tasiobg');
$url = new moodle_url('/admin/tool/tasiobg/index.php', []);
$PAGE->set_url($url);
$PAGE->set_context(context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);

$id = required_param('id', type: PARAM_INT);

// Extending the navigation.
$previewnode = $PAGE->navigation->add(
    'testNav1',
    new moodle_url('/admin/tool/tasiobg/index.php', ['id' => $id]),
    navigation_node::TYPE_CONTAINER
);
$thingnode = $previewnode->add(
    'testNav2',
    new moodle_url('/admin/tool/tasiobg/index.php', ['id' => 'fakeid'])
);
$thingnode->make_active();

echo $OUTPUT->header();
echo $OUTPUT->heading($title);

echo html_writer::div(get_string('helloworld', 'tool_tasiobg'));
echo html_writer::div(get_string('courseid', 'tool_tasiobg', $id));

$numofusers = $DB->count_records('user', ['confirmed' => 1]);
echo html_writer::div(get_string('numofregusers', 'tool_tasiobg', $numofusers));

$user = $DB->get_records_sql(
    "SELECT ul.userid, u.firstname, ul.timeaccess
            FROM {user_lastaccess} ul
            INNER JOIN {user} u ON ul.userid = u.id
            LIMIT 10");

if (!empty($user)) {
    echo html_writer::div('----');
    echo html_writer::div(get_string('lastaccesseduserslist', 'tool_tasiobg'));
    // Print table.
    echo '
    <table class="table">
        <thead>
            <tr>
                <th scope="col">'.get_string('userid', 'tool_tasiobg').'</th>
                <th scope="col">'.get_string('firstname', 'tool_tasiobg').'</th>
                <th scope="col">'.get_string('timeaccess', 'tool_tasiobg').'</th>
            </tr>
        </thead>';

    foreach ($user as $u) {
        echo "
            <tbody>
                <tr>
                    <th>$u->userid</th>
                    <td>".format_text($u->firstname, FORMAT_PLAIN)."</td>
                    <td>".userdate($u->timeaccess, get_string('strftimedatetime', 'core_langconfig'));".</td>
                </tr>
            </tbody>";
    }
    echo '</table>';
}

// Practice assignment "Use class table_sql".
echo html_writer::div('----table_sql----');
$table = new \tool_tasiobg\tableclass($url, $id);
$table->out(50, false);

echo $OUTPUT->footer();
