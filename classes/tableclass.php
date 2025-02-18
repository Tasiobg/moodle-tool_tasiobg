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
     * Display the data in tool_tasiobg_table for the current Course ID in a table using \table_sql
     * @param \moodle_url $url
     * @param int $courseid
     */
    public function __construct(\moodle_url $url, int $courseid) {
        global $CFG;
        parent::__construct('tool_tasiobg_table');

        $this->define_columns(['id', 'courseid', 'name', 'completed', 'priority', 'timecreated', 'timemodified']);
        $this->define_headers([
            get_string('tableid', 'tool_tasiobg'),
            get_string('tablecourseid', 'tool_tasiobg'),
            get_string('tablename', 'tool_tasiobg'),
            get_string('tablecompleted', 'tool_tasiobg'),
            get_string('tablepriority', 'tool_tasiobg'),
            get_string('tabletimecreated', 'tool_tasiobg'),
            get_string('tabletimemodified', 'tool_tasiobg')]);
        $this->collapsible(false);
        $this->sortable(false);
        $this->pageable(true);
        $this->is_downloadable(false);
        $this->define_baseurl($url);

        $this->set_sql("id, courseid, name, completed, priority, timecreated, timemodified",
            "{tool_tasiobg}", 'courseid = :courseid',
            ['courseid' => $courseid]);
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
        if ($row->completed === 1) {
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
}
