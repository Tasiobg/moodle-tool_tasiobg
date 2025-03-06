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
 * Plugin version info
 *
 * @module    tool_tasiobg/deletemodal
 * @copyright  2025 Tasio Bertomeu Gomez <tasio.bertomeu@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import {deleteCourseAndLoadPage} from './repository';
import ModalSaveCancel from 'core/modal_save_cancel';
import ModalEvents from 'core/modal_events';
import {get_string as getString} from 'core/str';

/**
 * Entrypoint of the js.
 *
 * @method init
 */
export const init = async() => {
    const deletelinks = document.querySelectorAll('#tasiobg-course-list-table .deletelink');
    if (deletelinks.length > 0) {
        deletelinks.forEach(deletelink => {
            deletelink?.addEventListener('click', async(e) => {
                e.preventDefault();
                const modal = await ModalSaveCancel.create({
                    title: getString('delete'),
                    body: getString('deletemodalconfirmation', 'tool_tasiobg'),
                    show: true,
                    removeOnClose: true,
                    buttons: {
                        'save': getString('delete'),
                        'cancel': getString('cancel'),
                    }
                });
                modal.getRoot().on(ModalEvents.save, () => {
                    deleteCourseAndLoadPage(deletelink.getAttribute('data-courseid'));
                });
            });
        });
    }
};
