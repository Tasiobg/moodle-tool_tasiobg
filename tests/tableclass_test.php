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

namespace tool_tasiobg;

use tool_tasiobg\tableclass;

/**
 * Tests for My first Moodle plugin
 *
 * @package    tool_tasiobg
 * @category   test
 * @copyright  2025 Tasio Bertomeu Gomez <tasio.bertomeu@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class tableclass_test extends \advanced_testcase {

    /**
     * Check if the edit button is generated when the user has the required capability
     *
     * @covers \tableclass::col_edit
     */
    public function test_col_edit_as_admin(): void {
        $this->resetAfterTest(false);
        $this->setAdminUser();

        $url = new \moodle_url('/admin/tool/tasiobg/index.php', []);;
        $table = new tableclass($url, 1);
        $row = new \stdClass();
        $row->edit = '<a title="edit" href="#">Edit</a>';
        $this->assertEquals('<a title="edit" href="#">Edit</a>', $table->col_edit($row));
    }

    /**
     * Check if the edit button is an empty string when the user doesn't have the required capability
     *
     * @covers \tableclass::col_edit
     */
    public function test_col_edit_as_guest(): void {
        $this->resetAfterTest(false);
        $this->setGuestUser();

        $url = new \moodle_url('/admin/tool/tasiobg/index.php', []);;
        $table = new tableclass($url, 1);
        $row = new \stdClass();
        $row->edit = '<a title="edit" href="#">Edit</a>';
        $this->assertEquals('', $table->col_edit($row));
    }
}
