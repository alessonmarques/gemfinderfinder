<?php 
/**
 * Verify if the quantity of the Internal TXs on database are different 
 * from the obtained at BSC.
 */
if($count_internalTXList != count($internalTXList)) {
    
    /**
     * Get the last TX registrated to that wallet in the BD.
     */
    $sql = "SELECT * FROM tx_internal WHERE _to = '{$probed_wallet->id}' ORDER BY timestamp DESC LIMIT 1";
    $last_internalTX = $connection->select($sql)[0];

    /**
     * Loop in the TX from BSC to persist the data in DB.
     */
    foreach ($internalTXList as $internalTX) {

        /**
         * Will stop the loop if the BSC Transaction Hash == The last Transaction Hash
         * in the database.
         */
        if($internalTX->hash == $last_internalTX->transaction_hash) {
            break;
        }

        $to_insert_internalTX[] = $internalTX;
    }

    /**
     * If have internalTX to Insert.
     */
    if($to_insert_internalTX) {
        /**
         * Define the values to insert variable.
         */
        $values = [];

        /**
         * Invert the array to insert.
         * Cuz when we get from the BSC the TXList come ordered in DESC.
         */
        $to_insert_internalTX = array_reverse($to_insert_internalTX);

        foreach ($to_insert_internalTX as $internalTX) {

            /**
             * Retrive the Date from TimeStamp.
             */
            $transaction_hash_date = date('Y-m-d H:i:s', $internalTX->timeStamp);
            
            /**
             * Set the hash into the values to be inserted.
             */
            $values[] = "('{$internalTX->hash}', {$internalTX->timeStamp}, '{$internalTX->from}', {$probed_wallet->id}, 0, 0, now())";
            
            /**
             * Save the message to send as report.
             */
            $normalTX->from_abreviation  = substr($normalTX->from, 0, 5) . "..." . substr($normalTX->from, 40, 6);
            $normalTX->to_abreviation    = substr($normalTX->to, 0, 5) . "..." . substr($normalTX->to, 40, 6);

            $normalTX->tx_abreviation    = substr($normalTX->hash, 0, 5) . "..." . substr($normalTX->hash, 40, 15);

            $report->messages["{$internalTX->timeStamp}.in"] = //"\n The address {$internalTX->from}  to {$internalTX->to} at {$transaction_hash_date}. \nYou can check it in the TX: {$internalTX->hash}.";
                                                                //"<pre>".
                                                                "\nThe address <b>{$normalTX->to_abreviation}</b> at <b>{$transaction_hash_date}</b>".
                                                                "\nreceived a transaction from <b>{$normalTX->from_abreviation}</b>".
                                                                "\n<a href=\"https://bscscan.com/tx/{$normalTX->hash}\">Click here to check it in the TX: {$normalTX->tx_abreviation}</a>".
                                                                "";
                                                                //"</pre>";
        }
        /**
         * Implode the values to insert all rows in same exectuion.
         */
        $values = implode(',', $values);

        /**
         * Insert the transactions hash to DB.
         */
        $sql = "INSERT INTO tx_internal (transaction_hash, timestamp, _from, _to, price, quantity, date) VALUES {$values}";
        $connection->execute($sql);

    }
}