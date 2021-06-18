<?php

    /**
    * Start the autoloader to bring all classes to the system.
    */
    require __DIR__ . '/../bootstrap.php';

    use Telegram\Telegram;
    
    $telegram = new Telegram();
    $telegram->commandsHandler(true);
    $telegram->regCommands();