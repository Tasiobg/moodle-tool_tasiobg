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

namespace tool_tasiobg;

use moodle_url;

defined('MOODLE_INTERNAL') || die();

global $CFG;

/**
 * Class tableclass
 *
 * @package    tool_tasiobg
 * @copyright  2025 Tasio Bertomeu Gomez <tasio.bertomeu@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tableclass extends \table_sql {

    /**
     * @var int $courseid The ID of the course.
     */
    protected $courseid = 0;

    /**
     * Display the data from the DB table tool_tasiobg for the current Course ID in a HTML table using \table_sql
     * @param \moodle_url $url
     * @param int $courseid
     */
    public function __construct(moodle_url $url, int $courseid) {
        global $CFG, $DB;
        parent::__construct('tool_tasiobg_table');
        $this->courseid = $courseid;

        $this->define_columns(['id', 'courseid', 'name', 'completed', 'priority', 'timecreated', 'timemodified', 'edit']);
        $this->define_headers([
            get_string('tableid', 'tool_tasiobg'),
            get_string('tablecourseid', 'tool_tasiobg'),
            get_string('tablename', 'tool_tasiobg'),
            get_string('tablecompleted', 'tool_tasiobg'),
            get_string('tablepriority', 'tool_tasiobg'),
            get_string('tabletimecreated', 'tool_tasiobg'),
            get_string('tabletimemodified', 'tool_tasiobg'),
            get_string('edit')]);
        $this->collapsible(false);
        $this->sortable(false);
        $this->pageable(true);
        $this->is_downloadable(false);
        $this->define_baseurl($url);
    }

    /**
     * Query the reader. Store results in the object for use by build_table.
     *
     * @param int $pagesize size of page for paginated displayed table.
     * @param bool $useinitialsbar do you want to use the initials bar.
     */
    public function query_db($pagesize, $useinitialsbar = true) {
        global $DB, $OUTPUT;
        $courses = $DB->get_records_sql(
            'SELECT id, courseid, name, completed, priority, timecreated, timemodified
            FROM {tool_tasiobg}
            WHERE courseid = :courseid',
            ['courseid' => $this->courseid]
        );

        foreach ($courses as $course) {
            $urledit = new moodle_url('/admin/tool/tasiobg/edit.php', ['entryid' => $course->id]);
            $course->edit = '<a title="' . get_string('edit') . '" href="'. $urledit . '">' .
                $OUTPUT->pix_icon('t/' . 'edit', get_string('edit')) . '</a>';
            $this->rawdata[] = $course;
        }
    }

    /**
     * Colum name output
     * @param \stdClass $row
     * @return string
     */
    public function col_name(\stdClass $row) {
        return format_text($row->name, FORMAT_PLAIN);
    }

    /**
     * Colum completed output
     * @param \stdClass $row
     * @return string
     */
    public function col_completed(\stdClass $row) {
        if ($row->completed == 1) {
            return get_string('yes');
        }
        return get_string('no');
    }

    /**
     * Colum timecreated output
     * @param \stdClass $row
     * @return string
     */
    public function col_timecreated(\stdClass $row) {
        return userdate($row->timecreated, get_string('strftimedatetime', 'core_langconfig'));
    }

    /**
     * Colum timemodified output
     * @param \stdClass $row
     * @return string
     */
    public function col_timemodified(\stdClass $row) {
        return userdate($row->timemodified, get_string('strftimedatetime', 'core_langconfig'));
    }

    /**
     * Colum edit output. Only display if user has edit capability
     * @param \stdClass $row
     * @return string
     */
    public function col_edit(\stdClass $row) {
        global $PAGE;
        if (has_capability('tool/tasiobg:edit', $PAGE->context)) {
            return $row->edit;
        }
        return '';
    }
}
