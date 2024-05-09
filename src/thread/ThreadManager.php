<?php

namespace CJMustard1452\translate\thread;

use CJMustard1452\translate\event\TranslatedChatEvent;
use CJMustard1452\translate\Loader;
use pmmp\thread\ThreadSafeArray;

class ThreadManager {

    private static TranslateThread $thread;
    private static int $id = 0;

    public function __construct(Loader $loader) {
        $notifer = $loader->getServer()->getTickSleeper()->addNotifier(function (): void {
            self::$thread->collectResults();
        });

        self::$thread = new TranslateThread($notifer, $loader::$config["APIKey"]);
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
        new TranslatedChatEvent($data["target"], $data['translatedText'], $data['username']);
    }
}