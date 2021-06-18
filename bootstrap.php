<?php 
    /**
     * Start the autoloader to bring all classes to the system.
     */
    require __DIR__ . '/vendor/autoload.php';
    
    /**
     * Load the Environment variables.
     */
    new Config\Environment("config/.env");