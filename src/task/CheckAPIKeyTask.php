<?php

namespace CJMustard1452\translate\task;

use CJMustard1452\translate\Loader;
use pocketmine\scheduler\AsyncTask;

class CheckAPIKeyTask extends AsyncTask {

    private string $response;

    private const ERROR_MESSAGE = "API key not valid. Please pass a valid API key.";

    public function __construct(private string $apiKey) {
        // NOOP
    }

    public function onRun(): void {
        $body = [
            "q" => "",
            "target" => "",
            "source" => ""
        ];

        $ch = curl_init("https://translation.googleapis.com/language/translate/v2?key=" . $this->apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            
        $this->response = curl_exec($ch);
    }

    public function onCompletion(): void {
        $instance = Loader::getInstance();

        $data = json_decode($this->response, true);
        if(isset($data["error"]) && $data["error"]["message"] == self::ERROR_MESSAGE) {
            $instance->getScheduler()->scheduleDelayedTask(new InvalidKeyTask(), $instance->getServer()->getTicksPerSecond());

            return;
        }

        $instance::enable();
    }
}