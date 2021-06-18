<?php

    use Telegram\Telegram;

    /**
    * Start the autoloader to bring all classes to the system.
    */
    require __DIR__ . '/../bootstrap.php';
    
    $telegram = new Telegram();
    $telegram->commandsHandler(true);
    $telegram->regCommands();
