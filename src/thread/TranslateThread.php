<?php

namespace CJMustard1452\translate\thread;

use pocketmine\snooze\SleeperHandlerEntry;
use pmmp\thread\ThreadSafeArray;
use pocketmine\thread\Thread;

class TranslateThread extends Thread {

    private SleeperHandlerEntry $notifier;
    public ThreadSafeArray $results;
    public ThreadSafeArray $queue;
    public bool $running = true;
    private string $apikey;

    public function __construct(SleeperHandlerEntry $notifier, string $apikey) {
        $this->notifier = $notifier;
        $this->apikey = $apikey;

        $this->results = new ThreadSafeArray();
        $this->queue = new ThreadSafeArray();

        $this->start();
    }

    public function onRun(): void {
        $notifier = $this->notifier->createNotifier();

        while($this->running) {
            while(($data = $this->queue->shift()) !== null) {
                if($data['origin'] == null) $body = [ "q" => $data['content'], "target" => $data['language'] ];
                else $body = [ "q" => $data['content'], "target" => $data['language'], "source" => $data['origin']];

                $ch = curl_init("https://translation.googleapis.com/language/translate/v2?key=" . $this->apikey);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
                    
                $response = curl_exec($ch);

                if(!isset(json_decode($response, true)['data']['translations'][0]['translatedText'])) continue;
                $return["translatedText"] = json_decode($response, true)['data']['translations'][0]['translatedText'];
                $return["target"] = $body["target"];
                $return["origin"] = $data["content"];
                $return["username"] = $data['username'];

                $this->results[] = ThreadSafeArray::fromArray($return);
            }
            
            $notifier->wakeupSleeper();
        }
    }

    public function addRequest(array $array): void {
        $this->queue[] = ThreadSafeArray::fromArray($array);
    }

    public function collectResults(): void {
        while(($result = $this->results->shift()) !== null) {
            ThreadManager::collectResults($result);
        }
    }
}