<?php

use Core\Task\TaskManager;

$task_manager = new TaskManager();
//$task_manager->verify_probed_wallets();

$message = $_GET['message'];
$task_manager->send_custom_message_to_group($message);