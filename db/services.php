<?php

/**
 * List of Web Services for the tool_externaltaskmonitor plugin.
 *
 * @package tool_externaltaskmonitor
 */

defined('MOODLE_INTERNAL') || die();

$functions = array(
    'tool_externaltaskmonitor_get_scheduled_tasks' => array(
        'classname' => 'tool_externaltaskmonitor\external\monitor',
        'methodname' => 'get_scheduled_tasks',
        'description' => 'Gets all scheduled tasks.',
        'type' => 'read',
        'capabilities' => 'moodle/site:config',
        'ajax' => false,
    ),
);
