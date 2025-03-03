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

namespace tool_tasiobg\output;

/**
 * Renderer for My first Moodle plugin
 *
 * @package    tool_tasiobg
 * @copyright  2025 Tasio Bertomeu Gomez <tasio.bertomeu@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends \plugin_renderer_base implements \renderable, \templatable {
    /**
     * Renders the "Hello, World!" message.
     *
     * @return string The rendered "Hello, World!" message.
     */
    public function render_hello_world(): string {
        return \html_writer::div(get_string('helloworld', 'tool_tasiobg'));
    }

    /**
     * Exports data for use in a mustache template.
     *
     * @param \renderer_base $output The renderer base instance.
     * @return \stdClass Data to be used in the template.
     */
    public function export_for_template(\renderer_base $output) {
        $data = new \stdClass();
        $data->helloworld = get_string('helloworld', 'tool_tasiobg');
        return $data;
    }
}
