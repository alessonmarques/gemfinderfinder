<?php 

namespace Telegram\Commands;

use Telegram\Bot\Commands\Command;

class HelloCommand extends Command {

    protected $name = 'hello';

    public function handle() {
    
        $update = $this->getUpdate();
    	$user = $update->getMessage()->from;

        $this->replyWithMessage([
            'text' => "Hello {$user->username}"
        ]);

    }

}