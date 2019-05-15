<?php
/**
 * Created by PhpStorm.
 * User: ivzhenko.volodymyr
 * Date: 15.05.2019
 * Time: 10:40
 */

namespace app\controllers;


use app\structures\ActivityStructure;
use Klein\Request;
use Klein\Response;

final class LogController
{
    public function sendActivity (Request $request, Response $response)
    {
        $paramsPost = $request->paramsPost();
        
        $activityStructure = new ActivityStructure($paramsPost);
        
        $message = $this->createActivityMessage($activityStructure);

        return $this->sendToTelegram($message);
    }

    private function sendToTelegram(string $message = ''): bool
    {
        $dataLink = TELEGRAM_API_BOT . '/sendMessage?' . http_build_query([
            'chat_id' => TELEGRAM_CHAT_ID,
            'text' => $message
        ]);
        file_get_contents($dataLink);

        return true;
    }

    private function createActivityMessage(ActivityStructure $activityStructure)
    {
        $message = '';

        foreach ($activityStructure as $key => $value) {
            $key = strtoupper($key);
            $message .= "{$key}: {$value}" . PHP_EOL;
        }

        return $message;
    }
}