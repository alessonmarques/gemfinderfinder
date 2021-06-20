<?php 

namespace Core\Task;

use Exception;

class TaskManager
{      
    /**
     * Defines the TaskManager constructor.
     */
    function __construct() { }

    function __call($task, $arguments)
    {
        
        /**
         * Assume the real task name.
         */
        $task = "task_{$task}";

        /**
         * Turns the arguments into array by json_decoding.
         */
        if (isset($arguments) && !empty($arguments))
        {

            /**
             * Decodes the received json to an array.
             */
            $arguments = json_decode($arguments[0], TRUE);

            /**
             * Turns the arguments into numbered parameters.
             */
            foreach ($arguments as $argument) {
                $parameters[] = $argument;
            }

        }

        /**
         * Verify if the task actually exists.
         */
        if ( !method_exists($this, $task) ) {

            throw new Exception("This method does not exist or aren't registrated to the TaskManager.");

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

        require 'Tasks/send_custom_message_to_group/send_custom_message_to_group.php';

    }
    

}