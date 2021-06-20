<?php 

namespace Telegram\Commands;

use Core\PDO\Connection;
use Telegram\Bot\Commands\Command;


class StartCommand extends Command {

    protected $name = 'start';

    protected $pattern = '{wallet}?';

    public function handle() {
        /**
         * Inititate the BD connection.
         */
        $connection  = new Connection();

        /**
         * Retrieve the data from the Telegram.
         */
        $update         = $this->getUpdate();
        $telegram_user  = $update->getMessage()->from;

        $arguments      = collect($this->arguments);
        $wallet_id = $arguments->get('wallet', '');

        /**
         *  Verify the DB if the telegram_id is already registered.
         */
        $sql = "SELECT * FROM users WHERE telegram_id = '{$telegram_user->id}'";
        $user = $connection->select($sql)[0];

        /**
         * If the user isnt registrated insert him into the DB.
         */
        if(!$user) {
            $sql = "INSERT INTO users (first_name, last_name, telegram_username, telegram_id, is_probed, status, created, updated) VALUES ('{$telegram_user->first_name}', '{$telegram_user->last_name}', '{$telegram_user->username}', '{$telegram_user->id}', FALSE, TRUE, now(), now())";
            $connection->execute($sql);

            /**
             *  Verify the DB if the telegram_id is already registered.
             */
            $sql = "SELECT * FROM users WHERE telegram_id = '{$telegram_user->id}'";
            $user = $connection->select($sql);
        }

        if($user)
        {
            $sql = "SELECT * FROM user_wallet WHERE user = '{$user->id}'";
            $wallets = $connection->select($sql);
            
            if($wallets) {
               
                $wallets_list = [];

                foreach ($wallets as $wallet_registrated) {

                    if ($wallet_id == $wallet_registrated->address) {

                        unset($wallet_id);
                        $wallet_already_registrated = true;

                    }

                    $wallets_list[] = $wallet_registrated->address;

                }

                $wallets_list = implode("\n", $wallets_list);
                $wallets_list = "\n" . $wallets_list . "\n";

                if ($wallet_already_registrated) {
                    $this->replyWithMessage([
                        'text' => "That wallet already is registrated."
                    ]);
                }
                else 
                {
                    $this->replyWithMessage([
                        'text' => "You've already registrated with the wallet(s):\n{$wallets_list}\nTo register another wallet just type \"/start\" followed by your wallet address.\nI.E.: /start 0xe...00009"
                    ]);
                }
            }
            
            if(!$wallets && !$wallet_id) {

                $this->replyWithMessage([
                    'text' => "You've already registrated.\nTo register a wallet just type \"/start\" followed by your new wallet address.\nI.E.: /start 0xe...00009"
                ]);

            }

            if ($wallet_id) {

                $sql = "INSERT INTO user_wallet (user, address, created, updated) 
                        VALUES ('{$user->id}', '{$wallet_id}', now(), now())";
                $connection->execute($sql);

                $this->replyWithMessage([
                    'text' => "You've successfully inserted the wallet:\n{$wallet_id}"
                ]);

            }
        }
    }
}