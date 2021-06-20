<?php 

namespace Telegram\Commands;

use Telegram\Bot\Commands\Command;

class HelloCommand extends Command {

    protected $name = 'hello';

    public function handle() {
    
        $update = $this->getUpdate();
    	$userid = $update->getMessage()->from->id;

        //$arguments = $this->getArguments();

        // $this->replyWithMessage([
        //     'text' => json_encode($arguments)
        // ]);
        
        // $this->replyWithMessage([
        //     'text' => json_encode($update)
        // ]);

        $this->replyWithMessage([
            'text' => "Hello World {$userid}"
        ]);

    }

}