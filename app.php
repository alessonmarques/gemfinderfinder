<?php

    /* http://localhost/gemfinderfinder/?wallet=0xe99831A2bD01C812fd91038B03FE2f09dAA9F0A7&debug=1 */

    use Codenixsv\CoinGeckoApi\CoinGeckoClient;
    use Core\Account;
    use Telegram\Telegram;

    if(isset($_GET['wallet']) && !empty($_GET['wallet']))
    {
    
        $wallet     = $_GET['wallet'];
        $account    = new Account($wallet);


        $gecko = new CoinGeckoClient();
        //$data = $gecko->ping();

        $telegram = new Telegram();
               
        //print_r($account->getNormalTXList());
        die();
    }