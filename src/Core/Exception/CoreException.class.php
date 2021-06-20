<?php 

namespace Core\Message;

use Exception;

class Messenger {
    
    function __construct($message = "", $code = 0, $previous = null) {

        $mode = $_SESSION['options']['mode'] ? $_SESSION['options']['mode'] : 'undefined';

        /**
         * Returns the error with json.
         */
        if ($mode == 'json') {
            echo "{\"message\": \"{$message}\"}";
            die();
        }

        /**
         * Returns the error with throwable Message.
         */
        if ($mode == 'undefined') {

            throw new Exception($message, $code, $previous);

        }

    }

}