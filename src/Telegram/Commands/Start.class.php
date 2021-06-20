<?php 

namespace Telegram\Commands;

use Core\PDO\Connection;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command {

    protected $name = 'start';

    public function handle() {
    
        //$update = $this->getUpdate();
    	//$userid = $update->getMessage()->from->id;

        $arguments = $this->getArguments();


        /**
         * Define the connection with DB.
         */
        $connection = new Connection();

        $this->replyWithMessage([
            'text' => json_encode($arguments)
        ]);

    }

}