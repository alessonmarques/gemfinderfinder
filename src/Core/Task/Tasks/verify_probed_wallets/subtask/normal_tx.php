<?php 
/**
 * Verify if the quantity of the Normal TXs on database are different 
 * from the obtained at BSC.
 */
if($count_normalTXList != count($normalTXList)) {
    
    /**
     * Get the last TX registrated to that wallet in the BD.
     */
    $sql = "SELECT * FROM tx_normal WHERE _from = '{$probed_wallet->id}' ORDER BY timestamp DESC LIMIT 1";
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
    if($to_insert_normalTX) {
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
            $report->messages["{$normalTX->timeStamp}.out"] = "\n The address {$normalTX->from} make a transaction to {$normalTX->to} at {$transaction_hash_date}. \nYou can check it in the TX: {$normalTX->hash}.";

        }
        /**
         * Implode the values to insert all rows in same exectuion.
         */
        $values = implode(',', $values);

        /**
         * Insert the transactions hash to DB.
         */
        $sql = "INSERT INTO tx_normal (transaction_hash, timestamp, _from, _to, price, quantity, date) VALUES {$values}";
        $connection->execute($sql);

    }
}