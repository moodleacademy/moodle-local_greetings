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
 * TODO describe module greetings
 *
 * @module     local_greetings/greetings
 * @copyright  2024 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import Selectors from 'local_greetings/local/greetings/selectors';
import * as Repository from 'local_greetings/local/greetings/repository';
import * as Str from 'core/str';

/**
 *
 * @param {Number} userid
 */
export const init = (userid) => {
    registerEventListeners(userid);
};

/**
 *
 * @param {Number} userid
 */
const registerEventListeners = (userid) => {
    document.addEventListener('click', e =>  {
        if (e.target.closest(Selectors.actions.showGreetingButton)) {
            let greetingBlock = document.querySelector(Selectors.regions.greetingBlock);

            Repository.getUser(userid)
            .then(function(response) {
                window.console.log("Country: " + response[0].country);
            });

            if (greetingBlock) {
                let name = document.querySelector(Selectors.regions.inputField);
                let msg = document.createElement("h2");

                userGreeting(name.value)
                .then((greetingStr) => {
                    msg.append(greetingStr);
                    greetingBlock.append(msg);
                })
                .catch();
            }
        }
        if (e.target.closest(Selectors.actions.resetButton)) {
            let name = document.querySelector(Selectors.regions.inputField);
            name.value = '';

            let xx = document.querySelector(Selectors.regions.greetingBlock);
            xx.innerHTML  = '';
        }
    });
};

/**
 * Return a personalised greeting.
 *
 * @param   {String} name The name of the person to greet
 * @returns {Promise}
 */
const userGreeting = (name) => Str.getString('greetinguserau', 'local_greetings', name);
