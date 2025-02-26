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

// NOTE: no MOODLE_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../../../lib/behat/behat_base.php');

/**
 * Behat steps in plugin tool_tasiobg
 *
 * @package    tool_tasiobg
 * @category   test
 * @copyright  2025 Tasio Bertomeu Gomez <tasio.bertomeu@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_tool_tasiobg extends behat_base {
    /**
     * Check that we can see the new row.
     * @Given /^I should see the new row "(?P<nodetext_string>(?:[^"]|\\")*)"$/
     *
     * @param string $nodetext
     */
    public function i_see_the_new_row($nodetext) {
        echo $nodetext;
        $container = $this->get_selected_node('text', $nodetext);
    }
}
