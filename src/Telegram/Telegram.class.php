<?php
/**
 *  Taken from: https://dev.to/fadymr/php-create-your-own-php-dotenv-3k2i
 */

namespace Telegram;

use Telegram\Commands\HelloCommand;
use Telegram\Bot\Api;
class Telegram extends Api
{
    private $commands = [
        HelloCommand::class,
    ];

    /**
     * Defines the constructor and starts the parent with the bot token.
     */
    function __construct() {
    
        parent::__construct($_ENV['APP_TELEGRAM_BOT_TOKEN']);
        $this->addCommands($this->commands);
    }
    
}