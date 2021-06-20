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

    /**
     * Defines the send_custom_message_to_group Function.
     */
    function send_custom_message_to_group($message) {
        require 'Tasks/send_custom_message_to_group/send_custom_message_to_group.php';
    }

}