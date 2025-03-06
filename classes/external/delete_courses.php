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

declare(strict_types=1);

namespace tool_tasiobg\external;

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_value;

/**
 * Class delete_courses
 *
 * @package    tool_tasiobg
 * @copyright  2025 Tasio Bertomeu Gomez <tasio.bertomeu@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class delete_courses extends external_api {

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'courseid' => new external_value(PARAM_INT, 'Course ID', VALUE_REQUIRED),
        ]);
    }

    /**
     * Describes the return structure of the service.
     *
     * @return external_single_structure
     */
    public static function execute_returns(): external_single_structure {
        return new external_single_structure(
            [
                'result' => new external_value(PARAM_BOOL, 'Whether the course was properly deleted or not.'),
            ]
        );
    }

    /**
     * Deletes a course based on the provided course ID.
     *
     * @param int $courseid The ID of the course to be deleted.
     * @return array
     */
    public static function execute($courseid) {
        global $DB;
        $params = external_api::validate_parameters(self::execute_parameters(), [
            'courseid' => $courseid,
        ]);

        // Validate context.
        $context = \context_system::instance();
        self::validate_context($context);

        require_capability('tool/tasiobg:edit', $context);

        $result = $DB->delete_records('tool_tasiobg', ['id' => $courseid]);

        return ['result' => true];
    }
}
