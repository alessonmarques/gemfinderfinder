<?php

/**
 * Get  the class prototype to check the method uses.
 */
require "./src/Core/Task/TaskManager.class.php";
use Core\Task\TaskManager;

/**
 * Get the $_GET[''] parameters.
 */
$task       = isset($_GET['task']) && !empty($_GET['task']) ? $_GET['task'] : '';
$parameters = isset($_GET['parameters']) && !empty($_GET['parameters']) ? $_GET['parameters'] : '';
$options    = isset($_GET['options']) && !empty($_GET['options']) ? $_GET['options'] : '';

/**
 * Check if the method doesn't exists and show the HeberMachine home page.
 */
if (!method_exists(TaskManager::class, "task_{$task}"))
{
    require __DIR__ . "/HebernMachine.php";
    die();
}