<?php

/**
 * Extract every variable in $_GET['options'];
 */
if (isset($options) && !empty($options))
{

    /**
     * Decodes the received json to an array.
     */
    $options = json_decode($options, TRUE);

    if(json_last_error() === JSON_ERROR_NONE && is_array($options))
    {

        extract($options);

    }

}

/**
 * Define the header to return data in JSOn.
 */
if($mode == 'json')
{
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json; charset=utf-8');
    header("Cache-Control: no-cache, no-store, must-revalidate");
}