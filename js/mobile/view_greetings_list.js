// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

const translate = key => this.TranslateService.instant(`plugin.local_greetings.${key}`);

this.addMessage = () => {
    const alertOptions = {
        header: translate('addmessage'),
        inputs: [{
            name: 'message',
            type: 'textarea',
            placeholder: translate('yourmessage'),
        }],
        buttons: [{
            text: translate('submit'),
            handler: ({ message }) => {
                if (!message) {
                    return;
                }

                this.CoreSitesProvider
                    .getCurrentSite()
                    .write('local_greetings_add_message', { message })
                    .then(() => this.refreshContent());
            },
        }],
    };

    this.AlertController
        .create(alertOptions)
        .then(alert => alert.present());
};
