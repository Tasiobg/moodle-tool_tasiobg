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
 * Capability definitions for My first Moodle plugin
 *
 * Documentation: {@link https://moodledev.io/docs/apis/subsystems/access}
 *
 * @package    tool_tasiobg
 * @category   access
 * @copyright  2025 Tasio Bertomeu Gomez <tasio.bertomeu@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$capabilities = [
    'tool/tasiobg:view' => [
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
    ],
    'tool/tasiobg:edit' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
    ],
];
