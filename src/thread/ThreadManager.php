<?php

namespace CJMustard1452\translate\thread;

use pmmp\thread\ThreadSafeArray;
use CJMustard1452\translate\event\TranslatedChatEvent;
use CJMustard1452\translate\Loader;

class ThreadManager {

    private static TranslateThread $thread;
    private static int $id = 0;

    public function __construct(Loader $loader) {
        $notifer = $loader->getServer()->getTickSleeper()->addNotifier(function (): void {
            self::$thread->collectResults();
        });

        self::$thread = new TranslateThread($notifer, $loader::$config["APIKey"]);
    }

    public static function addRequest(array $languages, string $content, ?string $origin = null): void {
        foreach($languages as $language) {
            $data = [
                "id" => self::$id,
                "language" => $language,
                "content" => $content,
                "origin" => $origin
            ];
    
            self::$id++;
            self::$thread->addRequest($data);
        }
    }

    public static function shutdown(): void {
        if(isset(self::$thread)) self::$thread->running = false;
    }

    public static function collectResults(ThreadSafeArray $data): void {
        new TranslatedChatEvent($data["detectedSourceLanguage"], $data['translatedText']);
    }
}