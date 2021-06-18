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
    require __DIR__ . '/bootstrap.php';

    /**
     * Start the Main app file.
     */
    if($debug) echo "<pre>";
    require __DIR__ . '/app.php';
    if($debug) echo "</pre>";