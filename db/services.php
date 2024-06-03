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
 * Web service declarations for the tool_externaltaskmonitor plugin.
 *
 * @package    tool_externaltaskmonitor
 * @copyright  The Regents of the University of California
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = [
    'tool_externaltaskmonitor_get_scheduled_tasks' => [
        'classname' => 'tool_externaltaskmonitor\external\monitor',
        'methodname' => 'get_scheduled_tasks',
        'description' => 'Gets all scheduled tasks.',
        'type' => 'read',
        'capabilities' => 'moodle/site:config',
        'ajax' => false,
        'services' => ['externaltaskmonitor'],
    ],
];

$services = [
    'External task monitor'  => [
        'functions' => [],
        'enabled' => 0,
        'restrictedusers' => 1,
        'shortname' => 'externaltaskmonitor',
    ],
];
