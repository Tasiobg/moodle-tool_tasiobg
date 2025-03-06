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
 * TODO describe module repository
 *
 * @module     tool_tasiobg/repository
 * @copyright  2025 Tasio Bertomeu Gomez <tasio.bertomeu@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import {call as fetchMany} from 'core/ajax';
import {exception as displayException} from 'core/notification';
import Templates from 'core/templates';

const deleteCourse = (
    courseid,
) => fetchMany([{
    methodname: 'tool_tasiobg_delete_courses',
    args: {
        courseid,
    },
}])[0];


const renderSuccessTemplate = () => {
    Templates.renderForPromise('tool_tasiobg/success')
    .then(({html, js}) => {
        // Here eventually I have my compiled template, and any javascript that it generated.
        // The templates object has append, prepend and replace functions.
        return Templates.replaceNode('#page-content', html, js);
    })
    .catch((error) => displayException(error));
};


export const deleteCourseAndLoadPage = async(courseid) => {
    const response = await deleteCourse(courseid);
    if (response?.result) {
        window.console.log("Success");
    } else {
        window.console.log("Error");
    }
    renderSuccessTemplate();
};
