<?php 
    
    use Telegram\Telegram;

    /**
     * Start the autoloader to bring all classes to the system.
     */
    require __DIR__ . '/bootstrap.php';

    /**
     * Start the Setup.
     */
    $telegram = new Telegram();
    $telegram->setWebhook(['url' => $_ENV['APP_TELEGRAM_BOT_WEBHOOK']]);