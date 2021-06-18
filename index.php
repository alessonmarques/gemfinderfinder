<?php 

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