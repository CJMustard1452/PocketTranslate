<?php

namespace CJMustard1452\translate;

use CJMustard1452\translate\event\TranslatedChatEvent;
use CJMustard1452\translate\thread\ThreadManager;
use Closure;

class PocketTranslate {

    public static array $listeners = [];

    public const ENGLISH = "en";
    public const SPANISH = "es";
    public const FRENCH = "fr";
    public const TAIWAN = "zh-TW";
    public const PRC = "zh-CN";
    public const UKRAINIAN = "uk";
    public const TURKISH = "tr";
    public const SWEDISH = "sv";
    public const RUSSIAN = "ru";
    public const HEBREW = "iw";
    public const GERMAN = "de";
    public const FILIPINO = "fil";
    public const ARABIC = "ar";
    public const DUTCH = "nl";

    public static function RegisterListener(Closure $closure): void {
        self::$listeners[] = $closure;
    }

    public static function TranslateMessage(string $language, string $content, ?string $origin): void {
        ThreadManager::addRequest([$language], $content, $origin);
    }

    public static function TranslateMessages(array $languages, string $content, ?string $username = null, ?string $origin = null): void {
        ThreadManager::addRequest($languages, $content, $username, $origin);
    }

    public static function executeListeners(TranslatedChatEvent $translatedChatEvent): void {
        foreach(self::$listeners as $listener) {
            $listener($translatedChatEvent);
        }
    }

    public static function updatePlayerLanguage(string $name, string $lang): void {
        Loader::$players[strtolower($name)] = $lang;
    }

    public static function getPlayerLanguage(string $name): ?string {
        if(!isset(Loader::$players[strtolower($name)])) return null;
        return Loader::$players[strtolower($name)];
    }
}