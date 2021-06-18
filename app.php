<?php

    use Core\Account;
    
    $wallet     = '0xe99831A2bD01C812fd91038B03FE2f09dAA9F0A7';
    $account    = new Account($wallet);

    echo "<pre>";
    print_r($account->getTXList());
    echo "</pre>";
    die();