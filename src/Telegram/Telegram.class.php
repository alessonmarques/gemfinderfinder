<?php
/**
 *  Taken from: https://dev.to/fadymr/php-create-your-own-php-dotenv-3k2i
 */

namespace Telegram;

use Telegram\Bot\Api;

use Telegram\Commands\HelloCommand;
use Telegram\Commands\StartCommand;

class Telegram extends Api
{
    private $chat_groups_var_name = 'APP_TELEGRAM_BOT_CHAT_ID';
    private $chat_groups = [];

    private $commands = [
        HelloCommand::class,
        StartCommand::class,
    ];

    /**
     * Defines the constructor and starts the parent with the bot token.
     */
    function __construct() {
    
        parent::__construct($_ENV['APP_TELEGRAM_BOT_TOKEN']);

        $this->loadGroupsChatID();

        $this->addCommands($this->commands);

    }

    function loadGroupsChatID() {
        
        /**
         * On loading the Class will get from the ENV Those variables containing the
         * chat_groups named as APP_TELEGRAM_BOT_CHAT_ID_$N
         * And save it in the $chat_groups variable.
         */
        foreach ($_ENV as $key => $value) {

            if (substr($key, 0, strlen($this->chat_groups_var_name)) == $this->chat_groups_var_name) {

                $this->chat_groups[] = $value;

            }

        }

    }

    /**
     * This methods aims to send a message to every group listed 
     * in $chat_groups variable. Different from sendMessage which aims to send
     * only once.
     */
    function sendMessageToAllGroups (array $params) {

        foreach ($this->chat_groups as $chat_id) {

            $params['chat_id'] = $chat_id;

            $this->sendMessage($params);

        }
        
    }

}