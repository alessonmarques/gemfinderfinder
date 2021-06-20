<?php 
    /**
     * Routing script get the pre-defined parameters to check if 
     * everthing is ok and redirect to the route.
     */
    require __DIR__ . "/routing.php";

    /**
     * Options set how the info will be returned to the screen.
     */
    require __DIR__ . "/options.php";
    
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