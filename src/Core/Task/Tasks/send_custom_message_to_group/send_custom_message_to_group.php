<?php 

use Telegram\Telegram;

$telegram = new Telegram();

/**
 * Send the report to telegram.
 */
$telegram->sendMessageToAllGroups([
    'chat_id' => '',
    'text' => $message
]);