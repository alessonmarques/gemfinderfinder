<?php 

    // Just to test moment.
    if (!$_GET['wallet'])
    {
        require __DIR__ . "/HebernMachine.php";
        die();
    }

    $debug = $_GET['debug'];

    if(!$debug)
    {
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json; charset=utf-8');
        header("Cache-Control: no-cache, no-store, must-revalidate");
    }

    /**
     * Start the autoloader to bring all classes to the system.
     */
    require __DIR__ . '/vendor/autoload.php';
    
    /**
     * Load the Environment variables.
     */
    new Config\Environment("config/.env");