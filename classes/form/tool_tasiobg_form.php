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

namespace tool_tasiobg\form;

defined('MOODLE_INTERNAL') || die();

use moodleform;

global $CFG;
require_once($CFG->dirroot . '/lib/formslib.php');
/**
 * Class tool_tasiobg_form
 *
 * @package    tool_tasiobg
 * @copyright  2025 Tasio Bertomeu Gomez <tasio.bertomeu@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_tasiobg_form extends moodleform {
    /**
     * Form definition
     * @return void
     */
    public function definition() {
        // A reference to the form is stored in $this->form.
        // A common convention is to store it in a variable, such as `$mform`.
        $mform = $this->_form;
        $mform->addElement('hidden', 'courseid', $this->_customdata['courseid']);
        $mform->setType('courseid', PARAM_INT);
        $mform->addElement('hidden', 'entryid', $this->_customdata['entryid']);
        $mform->setType('entryid', PARAM_INT);
        $mform->addElement('text', 'name', get_string('name'));
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', get_string('pleaseentername', 'tool_tasiobg'));
        $mform->addElement('checkbox', 'completed', get_string('completed'));
        $mform->addElement('editor', 'description_editor', get_string('content'), null, [
            'trusttext' => true,
            'subdirs' => true,
            'maxfiles' => 99,
            'maxbytes' => get_config('moodlecourse', 'maxbytes'),
            'context' => \context_system::instance(),
        ]);
        $mform->setType('description_editor', PARAM_RAW);
        $mform->addElement('submit', null, get_string('submit'));
        $mform->addElement('cancel', null, get_string('back'));
    }

    /**
     * Ensure name is unique.
     *
     * @param array $data
     * @param array $files
     * @return array Error messages
     */
    public function validation($data, $files) {
        global $DB;
        $errors = [];
        $namealreadyexist = $DB->get_record_sql('SELECT * FROM {tool_tasiobg} WHERE name = :name AND id != :entryid',
            ['name' => trim($data['name']), 'entryid' => $data['entryid']],
            IGNORE_MISSING);
        if ($namealreadyexist) {
            $errors['name'] = get_string('namealreadyexist', 'tool_tasiobg');
        }
        return $errors;
    }
}
