<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Api;

class TelegramBotCommand extends Command
{
    protected $signature = 'telegram:bot';
    protected $description = 'Telegram botni ishga tushirish';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $updates = $telegram->getUpdates();

        foreach ($updates as $update) {
            $chatId = $update['message']['chat']['id'];
            $text = $update['message']['text'];

            if ($text === '/start') {
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Salom! Bu mening birinchi Telegram botim.',
                ]);
            }
        }
    }
}
