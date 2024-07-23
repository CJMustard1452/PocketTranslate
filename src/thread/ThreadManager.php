<?php

namespace CJMustard1452\translate\thread;

use CJMustard1452\translate\ChatTranslateEvent;
use CJMustard1452\translate\Loader;
use pmmp\thread\ThreadSafeArray;

class ThreadManager {

    private static TranslateThread $thread;
    private static int $id = 0;

    public function __construct() {
        $notifer = Loader::getInstance()->getServer()->getTickSleeper()->addNotifier(function (): void {
            self::$thread->collectResults();
        });

        self::$thread = new TranslateThread($notifer, Loader::$config["APIKey"]);
    }

    public static function addRequest(array $languages, string $content, ?string $username = null, ?string $origin = null): void {
        foreach($languages as $language) {
            $data = [
                "id" => self::$id,
                "language" => $language,
                "content" => $content,
                "origin" => $origin,
                "username" => $username
            ];
    
            self::$id++;
            self::$thread->addRequest($data);
        }
    }

    public static function shutdown(): void {
        if(isset(self::$thread)) self::$thread->running = false;
    }

    public static function collectResults(ThreadSafeArray $data): void {
        $event = new ChatTranslateEvent($data["target"], $data['translatedText'], $data['origin'], $data['username']);

        $event->call();
    }
}