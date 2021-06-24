<?php
/**
 * Define the variables that could be exported by 
 * the extract in the block below.
 */
$mode 	= '';
$debug 	= '';

/**
 * Extract every variable in $_GET['options'];
 */
if(isset($options) && !empty($options)) {

    /**
     * Decodes the received json to an array.
     */
    $_SESSION['options'] = $options = json_decode($options, TRUE);

    if(json_last_error() === JSON_ERROR_NONE && is_array($options)) {

        extract($options);

    }

}

/**
 * Define the header to return data in json.
 */
if($mode == 'json') {
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json; charset=utf-8');
    header("Cache-Control: no-cache, no-store, must-revalidate");
}