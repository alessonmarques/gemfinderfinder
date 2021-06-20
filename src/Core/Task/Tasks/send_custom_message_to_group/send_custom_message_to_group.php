<?php 

use Telegram\Telegram;

$telegram = new Telegram();

/**
 * Send the report to telegram.
 */
$telegram->sendMessage([
    'chat_id' => $_ENV['APP_TELEGRAM_BOT_CHAT_ID'],
    'text' => $message
]);