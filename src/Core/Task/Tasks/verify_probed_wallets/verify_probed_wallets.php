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
 * Run the loop with the probed_wallets.
 */
foreach ($probed_wallets as $probed_wallet) {

    /**
     * Set the date that the wallet scan started.
     */
	$run_start_date = date("Y-m-d h:i:s");

    /**
     * Define/Reset the report variable as a Default Class to store anything as report.
     */
    $report = new stdClass();
    $report->messages = [];

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

        $sql = "SELECT count(1) counter FROM tx_normal WHERE _from = '{$probed_wallet->id}'";
        $count_normalTXList = $connection->select($sql)[0]->counter;

        $sql = "SELECT count(1) counter FROM tx_internal WHERE _to = '{$probed_wallet->id}'";
        $count_internalTXList = $connection->select($sql)[0]->counter;

        /**
         * Calcs the total TX Count
         * just to know if is a new probed wallet.
         */
        $count_totalTXList = $count_normalTXList + $count_internalTXList;

        /**
         * If to sum of the TXs got equal 0, so is a new probed wallet.
         */
        $isANewProbedWallet = $count_totalTXList == 0 ? TRUE : FALSE;


        /**
         * Invoke the Account with the Address of the selected wallet.
         */
        $account = new Account($probed_wallet->address);

        /**
         * Get the TXs from the BSC Scan.
         */
        $normalTXList = $account->getNormalTXList()->result ? $account->getNormalTXList()->result : [];
        $internalTXList = $account->getInternalTXList()->result ? $account->getInternalTXList()->result : [];

        /**
         * Call the Sub-Task to check and insert the Normal TX;
         */
        include "subtask/normal_tx.php";

        /**
         * Call the Sub-Task to check and insert the Internal TX;
         */
        include "subtask/internal_tx.php";

    }
    
    if($report->messages && !$isANewProbedWallet) {

        /**
         * Sort the message array by key to mix the in and out ordened by TimeStamp.
         */
        ksort($report->messages);
        
        foreach ($report->messages as $TXmessage) {

            /**
             * Send the report to telegram.
             */
            $telegram->sendMessageToAllGroups([
                'chat_id' => '',
                'text' => $TXmessage,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => TRUE
            ]);

        }

    }

    $run_end_date = date("Y-m-d h:i:s");

    echo "LOG: Probed {$probed_wallet->address} verified at: {$run_start_date} ~ {$run_end_date} \n";
    
}

