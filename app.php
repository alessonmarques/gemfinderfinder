<?php

    /* http://localhost/gemfinderfinder/?wallet=0xe99831A2bD01C812fd91038B03FE2f09dAA9F0A7&debug=1 */

    use Codenixsv\CoinGeckoApi\CoinGeckoClient;
    use Core\Account;
    use Core\PDO\Connection;
    use Telegram\Telegram;
    
    $wallet     = $_GET['wallet'];
    $account    = new Account($wallet);

    $connection = new Connection();

    $sql = "SELECT * FROM probed_wallet WHERE status = 1 AND is_gemfinder = 1";
    $result = $connection->select($sql);

    /*
    if(isset($_GET['wallet']) && !empty($_GET['wallet']))
    {
    
        $wallet     = $_GET['wallet'];
        $account    = new Account($wallet);
        
        
        $gecko = new CoinGeckoClient();
        $data = $gecko->ping();

        $telegram = new Telegram();
        $telegram->sendMessage([
            'chat_id' => $_ENV['APP_TELEGRAM_BOT_CHAT_ID'],
            'text' => 'Successfully set up webhook ae porra.'
        ]);

        if(isset($_ENV['APP_TELEGRAM_BOT_CHAT_ID']) && !empty($_ENV['APP_TELEGRAM_BOT_CHAT_ID']))
        {
            //Exemplo de envio de mensagem.
            $telegram->sendMessage([
                'chat_id' => $_ENV['APP_TELEGRAM_BOT_CHAT_ID'],
                'text' => 'Successfully set up webhook'
            ]);
        }
       
               
        //print_r($account->getNormalTXList()->result);
        die();
    }
     */