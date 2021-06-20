<?php 

use Codenixsv\CoinGeckoApi\CoinGeckoClient;
use Core\Account;
use Core\PDO\Connection;
use Telegram\Telegram;

/**
 * Define the connection with DB.
 */
$connection = new Connection();

/**
 * Define the connection with Telegram.
 */
$telegram = new Telegram();

/**
 * Define the Probed_wallets.
 */
$sql = "SELECT * FROM probed_wallet WHERE status = 1 AND is_gemfinder = 1";
$probed_wallets = $connection->select($sql);

/**
 * Define the report as a default class to store anything as report.
 */
$report = new stdClass();

/**
 * Run the loop with the probed_wallets.
 */
foreach ($probed_wallets as $probed_wallet) {

    /**
     * Get the last TX registrated to that wallet in the BD.
     */
    $sql = "SELECT * FROM user_wallet WHERE user = '{$probed_wallet->user}' AND address = '{$probed_wallet->address}' ";
    $wallets = $connection->select($sql);

    foreach ($wallets as $probed_wallet) {
        /**
         * Define the user variable to hold the user->id
         */
        $user = $probed_wallet->user;

        /**
         * Define the insert arrays.
         */
        $to_insert_normalTX = [];
        $to_insert_internalTX = [];

        /**
         * Defining the count to get if we had all TXs.
         */
        $count_normalTXList = 0;
        $count_internalTXList = 0;

        $sql = "SELECT count(1) counter FROM tx_normal WHERE _from = '{$probed_wallet->address}'";
        $count_normalTXList = $connection->select($sql)[0]->counter;

        $sql = "SELECT count(1) counter FROM tx_internal WHERE _to = '{$probed_wallet->address}'";
        $count_internalTXList = $connection->select($sql)[0]->counter;

        /**
         * Invoke the Account with the Address of the selected wallet.
         */
        $account = new Account($probed_wallet->address);

        /**
         * Get the TXs from the BSC Scan.
         */
        $normalTXList = $account->getNormalTXList()->result;
        $internalTXList = $account->getInternalTXList()->result;

        /**
         * Verify if the quantity of the TXs on database are different 
         * from the obtained at BSC.
         */
        if($count_normalTXList != count($normalTXList)) {
            
            /**
             * Get the last TX registrated to that wallet in the BD.
             */
            $sql = "SELECT * FROM tx_normal WHERE _from = '{$probed_wallet->id}' ORDER BY transaction_hash DESC LIMIT 1";
            $last_normalTX = $connection->select($sql)[0];

            /**
             * Loop in the TX from BSC to persist the data in DB.
             */
            foreach ($normalTXList as $normalTX) {

                /**
                 * Will stop the loop if the BSC Transaction Hash == The last Transaction Hash
                 * in the database.
                 */
                if($normalTX->hash == $last_normalTX->transaction_hash) {
                    break;
                }

                $to_insert_normalTX[] = $normalTX;
            }

            /**
             * If have normalTX to Insert.
             */
            if ($to_insert_normalTX) {
                /**
                 * Define the values to insert variable.
                 */
                $values = [];

                /**
                 * Invert the array to insert.
                 * Cuz when we get from the BSC the TXList come ordered in DESC.
                 */
                $to_insert_normalTX = array_reverse($to_insert_normalTX);

                foreach ($to_insert_normalTX as $normalTX) {

                    /**
                     * Retrive the Date from TimeStamp.
                     */
                    $transaction_hash_date = date('Y-m-d H:i:s', $normalTX->timeStamp);
                    
                    /**
                     * Set the hash into the values to be inserted.
                     */
                    $values[] = "('{$normalTX->hash}', {$normalTX->timeStamp}, {$probed_wallet->id}, '{$normalTX->to}', 0, 0, now())";

                    /**
                     * Save the message to send as report.
                     */
                    $report->messages["{$normalTX->timeStamp}.out"] = "The address {$normalTX->from} make a transaction to {$normalTX->to} at {$transaction_hash_date}. {\n}You can check it in the TX: {$normalTX->hash}.";

                }
                /**
                 * Implode the values to insert all rows in same exectuion.
                 */
                $values = implode(',', $values);

                /**
                 * Insert the transactions hash to DB.
                 */
                $sql = "INSERT INTO tx_normal (transaction_hash, timestamp, _from, _to, price, quantity, date) VALUES {$values}";
                //$connection->execute($sql);
            }
        }
    }

    /**
     * Sort the message array by key to mix the in and out ordened by TimeStamp.
     */
    ksort($report->messages);

    /**
     * Join the whole array into a String to send as report to telegram chat_id.
     */
    $report_message = implode("\n", $report->messages);
    
    /**
     * Send the report to telegram.
     */
    $telegram->sendMessage([
        'chat_id' => $_ENV['APP_TELEGRAM_BOT_CHAT_ID'],
        'text' => $report_message
    ]);
    
}

