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
 * Upgrade steps for My first Moodle plugin
 *
 * Documentation: {@link https://moodledev.io/docs/guides/upgrade}
 *
 * @package    tool_tasiobg
 * @category   upgrade
 * @copyright  2025 Tasio Bertomeu Gomez <tasio.bertomeu@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Execute the plugin upgrade steps from the given old version.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_tool_tasiobg_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();

    if ($oldversion < 2025021005) {

        // Define table tool_tasiobg to be created.
        $table = new xmldb_table('tool_tasiobg');

        // Adding fields to table tool_tasiobg.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('completed', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('priority', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, null, null, null);

        // Adding keys to table tool_tasiobg.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for tool_tasiobg.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Tasiobg savepoint reached.
        upgrade_plugin_savepoint(true, 2025021005, 'tool', 'tasiobg');
    }

    if ($oldversion < 2025021007) {

        // Define table tool_tasiobg to be created.
        $table = new xmldb_table('tool_tasiobg');

        // Adding keys to table tool_tasiobg.
        $key = new xmldb_key('courseid_fi', XMLDB_KEY_FOREIGN, ['courseid'], 'course', ['id']);
        $dbman->add_key($table, $key);

        // Adding indexes to table tool_tasiobg.
        $index = new xmldb_index('courseid_name_ui', XMLDB_INDEX_UNIQUE, ['courseid', 'name']);
        $dbman->add_index($table, $index);

        // Tasiobg savepoint reached.
        upgrade_plugin_savepoint(true, 2025021007, 'tool', 'tasiobg');
    }

    return true;
}
