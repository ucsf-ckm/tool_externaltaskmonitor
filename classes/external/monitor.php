<?php

/**
 * Web Service functions for tool_externaltaskmonitor.
 *
 * @package tool_externaltaskmonitor
 */

namespace tool_externaltaskmonitor\external;

defined('MOODLE_INTERNAL') || die();

use context_system;
use core\task\manager;
use dml_exception;
use external_api;
use external_description;
use external_function_parameters;
use external_single_structure;
use external_multiple_structure;
use external_value;
use invalid_parameter_exception;
use required_capability_exception;
use restricted_context_exception;

/**
 * Web Service functions for external task monitor.
 */
class monitor extends external_api {

    /**
     * @return array
     * @throws dml_exception
     * @throws required_capability_exception
     * @throws invalid_parameter_exception
     * @throws restricted_context_exception
     */
    public static function get_scheduled_tasks() : array {
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
     * @return external_function_parameters
     */
    public static function get_scheduled_tasks_parameters() : external_function_parameters {
         return new external_function_parameters([]);
    }

    /**
     * @return external_description
     */
    public static function get_scheduled_tasks_returns() : external_description {
        return new external_multiple_structure(
            new external_single_structure([
                'component' => new external_value(PARAM_TEXT, 'Task Component', VALUE_REQUIRED),
                'class' => new external_value(PARAM_TEXT, 'Task Class', VALUE_REQUIRED),
                'lastruntime' => new external_value(PARAM_INT, 'Last Run Time', VALUE_REQUIRED),
                'disabled' => new external_value(PARAM_BOOL, 'Disabled', VALUE_REQUIRED)
            ])
        );
    }
}
