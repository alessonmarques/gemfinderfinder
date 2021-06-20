<?php 

namespace Telegram\Commands;

use Telegram\Bot\Commands\Command;

class HelloCommand extends Command {

    protected $name = 'hello';

    public function handle() {
    
        $update = $this->getUpdate();
    	$userid = $update->getMessage()->from->id;

        $this->replyWithMessage([
            'text' => "Hello World {$userid}"
        ]);

        $this->replyWithMessage([
            'text' => json_encode($update)
        ]);
    }

}