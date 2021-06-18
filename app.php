<?php

    use Codenixsv\CoinGeckoApi\CoinGeckoClient;
    use Core\Account;
    
    if(isset($_GET['wallet']) && !empty($_GET['wallet']))
    {
    
        $wallet     = $_GET['wallet'];
        $account    = new Account($wallet);


        $gecko = new CoinGeckoClient();
        $data = $gecko->ping();

        print_r($account->getNormalTXList());
        die();
    }