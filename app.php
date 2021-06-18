<?php

    use Codenixsv\CoinGeckoApi\CoinGeckoClient;
    use Core\Account;
    

    
    $wallet     = '0xe99831A2bD01C812fd91038B03FE2f09dAA9F0A7';
    $account    = new Account($wallet);


    $gecko = new CoinGeckoClient();
    $data = $gecko->ping();

    
    
    echo "<pre>";
        print_r($data);
        //print_r($account->getNormalTXList()->result[81]);
        print_r($account->getInternalTX('0x9e88e3914ddeabf3d8f76e5b27a38dd4872ec08e7f0043a26ffdc3944d74a57c'));
        //print_r($account->getInternalTXList());
    echo "</pre>";

    die();