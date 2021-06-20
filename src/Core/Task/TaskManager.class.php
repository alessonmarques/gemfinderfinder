<?php 

namespace Core\Task;

class TaskManager
{      
    /**
     * Defines the TaskManager constructor.
     */
    function __construct() { }
    
    /**
     * Defines the verify_probed_wallets Function.
     */
    function verify_probed_wallets() {
        require 'Tasks/verify_probed_wallets/verify_probed_wallets.php';
    }

}