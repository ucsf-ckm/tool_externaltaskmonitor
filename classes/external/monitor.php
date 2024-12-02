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
 * Web service functions for the tool_externaltaskmonitor plugin.
 *
 * @package    tool_externaltaskmonitor
 * @copyright  The Regents of the University of California
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_externaltaskmonitor\external;

use context_system;
use core\task\manager;
use dml_exception;
use core_external\external_api;
use core_external\external_description;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_multiple_structure;
use core_external\external_value;
use core_external\restricted_context_exception;
use invalid_parameter_exception;
use required_capability_exception;

/**
 * Web Service functions for external task monitor.
 */
class monitor extends external_api {

    /**
     * Implements the "tool_externaltaskmonitor_get_scheduled_tasks" web service endpoint.
     * Returns metadata about each scheduled tasks configured in this Moodle instance.
     * Each metadata item including the name, classname, status, and last-run timestamp of each scheduled task.
     *
     * @return array A list of medata for schedule tasks.
     * @throws dml_exception
     * @throws required_capability_exception
     * @throws invalid_parameter_exception
     * @throws restricted_context_exception
     */
    public static function get_scheduled_tasks(): array {
        $context = context_system::instance();
        self::validate_context($context);
        require_capability('moodle/site:config', $context);

        $tasks = manager::get_all_scheduled_tasks();

        $rhett = [];
        foreach ($tasks as $task) {
            $rhett[] = [
                'component' => $task->get_component(),
                'class' => get_class($task),
                'lastruntime' => $task->get_last_run_time(),
                'disabled' => $task->get_disabled(),
            ];
        }
        return $rhett;
    }

    /**
     * Defines the input parameters for the "tool_externaltaskmonitor_get_scheduled_tasks" web service endpoint.

     * @return external_function_parameters The parameter definition.
     */
    public static function get_scheduled_tasks_parameters(): external_function_parameters {
         return new external_function_parameters([]);
    }

    /**
     * Defines the output structure for the "tool_externaltaskmonitor_get_scheduled_tasks" web service endpoint.
     * @return external_description The output structure definition.
     */
    public static function get_scheduled_tasks_returns(): external_description {
        return new external_multiple_structure(
            new external_single_structure([
                'component' => new external_value(PARAM_TEXT, 'Task Component', VALUE_REQUIRED),
                'class' => new external_value(PARAM_TEXT, 'Task Class', VALUE_REQUIRED),
                'lastruntime' => new external_value(PARAM_INT, 'Last Run Time', VALUE_REQUIRED),
                'disabled' => new external_value(PARAM_BOOL, 'Disabled', VALUE_REQUIRED),
            ])
        );
    }
}
