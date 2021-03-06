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
            $internalTX->from_abreviation  = substr($internalTX->from, 0, 10) . "..." . substr($internalTX->from, 30, 6);
            $internalTX->to_abreviation    = substr($internalTX->to, 0, 10) . "..." . substr($internalTX->to, 30, 6);

            $internalTX->tx_abreviation    = substr($internalTX->hash, 0, 10) . "..." . substr($internalTX->hash, 45, 15);

            $report->messages["{$internalTX->timeStamp}.in"] = "\nThe <b>{$user->first_name} {$user->last_name}</b> at <b>[ {$transaction_hash_date} ]</b>".
                                                               "\nreceived a transaction from <b>{$internalTX->from_abreviation}</b>".

                                                               "\n\n<a href=\"https://bscscan.com/tx/{$internalTX->hash}\">BSC Scan: {$internalTX->tx_abreviation} - ???? </a>".

                                                               "";
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