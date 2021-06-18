<?php

    /**
    * Defines the log to get access data.
    */
    
    $SERVER_REQUEST_DATA = json_encode($_SERVER);
    error_log($SERVER_REQUEST_DATA);

    /**
    * Start the autoloader to bring all classes to the system.
    */
    require __DIR__ . '/../bootstrap.php';

    use Telegram\Telegram;
    
    $telegram = new Telegram();
    $telegram->commandsHandler(true);
    $telegram->regCommands();