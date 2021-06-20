<?php 

namespace Core\Task;

use Core\Message\Messenger;

class TaskManager
{      
    /**
     * Defines the TaskManager constructor.
     */
    function __construct() { }

    function __call($task, $arguments) {
    
        /**
         * Define the parameters variable.
         */
        $parameters = [];

        /**
         * Assume the real task name.
         */
        $task = "task_{$task}";

        /**
         * Turns the arguments into array by json_decoding.
         */
        if(isset($arguments[0]) && !empty($arguments[0])) {
        

            /**
             * Decodes the received json to an array.
             */
            $arguments = json_decode($arguments[0], TRUE);

            /**
             * Turns the arguments into numbered parameters.
             */
            if(json_last_error() === JSON_ERROR_NONE && is_array($arguments)) {
            
                foreach ($arguments as $argument) {
                    $parameters[] = $argument;
                }
            }

        }

        /**
         * If the parameters got empty set 1 to pass in the function call.
         */
        if(!$parameters) {
            $parameters[0] = 0;
        }

        /**
         * Verify if the task actually exists.
         */
        if(!method_exists($this, $task)) {

            new Messenger("This method does not exist or aren't registrated to the TaskManager.");

        }

        /**
         * Call the task with the correct name passing the parameters.
         */
        $this->$task( ...$parameters );

    }
    
    /**
     * Defines the verify_probed_wallets Function.
     */
    function task_verify_probed_wallets() {

        require 'Tasks/verify_probed_wallets/verify_probed_wallets.php';

    }

    /**
     * Defines the send_custom_message_to_group Function.
     */
    function task_send_custom_message_to_group($message) {
        
        /**
         * Verify if the parameters are given as expected.
         */
        if(!isset($message) || empty($message)) {
        

            new Messenger("The '\$message' parameter aren't defined.");

        }

        require 'Tasks/send_custom_message_to_group/send_custom_message_to_group.php';

    }
    

}