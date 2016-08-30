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
 * List outages
 *
 * @package    auth_outage
 * @author     Daniel Thee Roperto <daniel.roperto@catalyst-au.net>
 * @copyright  Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use \auth_outage\outage;

require_once('../../config.php');
require_once($CFG->libdir . '/adminlib.php');

// TODO Check parameters.

// Read https://docs.moodle.org/dev/Page_API#.24PAGE_The_Moodle_page_global for Page API info.
admin_externalpage_setup('auth_outage_manage'); // Does require_login and set_context inside.
$PAGE->set_url(new moodle_url('/auth/outage/list.php'));
$PAGE->set_title('Outage List');
$PAGE->set_heading('List of registered outages.');

$renderer = $PAGE->get_renderer('auth_outage');

$outagelist = [];
for ($i = 1; $i <= 10; $i++) {
    $outagelist[$i] = new outage();
    $outagelist[$i]->id = $i;
    $outagelist[$i]->starttime = time();
    $outagelist[$i]->stoptime = time() + 60 * 60 * 4; // 4 hours.
    $outagelist[$i]->warningminutes = 10 * $i;
    $outagelist[$i]->title = 'Outage #' . $i;
    $outagelist[$i]->description = 'This is the Outage #' . $i . ', backup creation.';
    $outagelist[$i]->createdby = 1;
    $outagelist[$i]->modifiedby = 1;
    $outagelist[$i]->lastmodified = time() - 60 * 60 * 10; // 10 hours ago.
};

echo $OUTPUT->header();

echo $renderer->renderoutagelist($outagelist);

echo $OUTPUT->footer();
