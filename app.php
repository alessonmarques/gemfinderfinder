<?php

use Core\Task\TaskManager;

/**
 * Instantiate the TaskManager to dinamically call the tasks.
 */
$task_manager = new TaskManager();

/**
 * $task = Parameter on $_GET['task'];
 * $parameters = Parameter on $_GET['parameters'];
 */
$task_manager->$task($parameters);

//$cmc = new CoinMarketCap\Api('yourApiClient');