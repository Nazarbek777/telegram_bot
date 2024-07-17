<?php

namespace App\Http\Controllers;

use App\Providers\TelegramBotProvider;

class BotController extends Controller
{

    public $chat_id;
    public $user_id;
    public $text;

    public function catch()
    {


        //offline
        $updates = $this->getUpdates();
        $request = end($updates['result']);

//        online
//        $updates = file_get_contents("php://input");
//        $request = json_decode($updates, true);

        $message = $request['message'];
        $from = $message['from'];
        $chat = $message['chat'];
        $this->user_id = $from['id'];
        $this->chat_id = $chat['id'];
        $this->text = $message['text'];


        if ($this->text == '/start'){ $this->start(); }
        if ($this->text == 'Retry'){ $this->retry(); }
    }



    public function start()
    {
        $this->sendRequest('sendMessage',[
            'chat_id' => $this->chat_id,
            'text' => 'Salom botimga xush kelibsiz',
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        [
                            'text' => '📞 Отправить номер',
                            'request_contact' => true
                        ],
                        [
                            'text' => 'Retry',
                        ],
                    ],
                ],
                'resize_keyboard' => true,
            ])
        ]);
    }

    public function retry()
    {
        $this->sendRequest('sendMessage',[
            'chat_id' => $this->chat_id,
            'text' => 'Retry ga kirdingiopadpfijsdf',
        ]);
    }




















    public function sendRequest($method, $parameters= [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot' . TelegramBotProvider::TOKEN . '/'.$method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        return json_decode($res, 1);
    }

    public function getUpdates($data = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot' . TelegramBotProvider::TOKEN . '/getUpdates');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        return json_decode($res, 1);
    }

}
