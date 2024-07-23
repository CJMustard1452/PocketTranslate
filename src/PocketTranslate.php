<?php

namespace CJMustard1452\translate;

use CJMustard1452\translate\thread\ThreadManager;

class PocketTranslate {

    public const ENGLISH_US = "en";
    public const AMHARIC = "am";
    public const ARABIC = "ar";
    public const BASQUE = "eu";
    public const BENGALI = "bn";
    public const ENGLISH_UK = "en-GB";
    public const PORTUGUESE_BRAZIL = "pt-BR";
    public const BULGARIAN = "bg";
    public const CATALAN = "ca";
    public const CHEROKEE = "chr";
    public const CROATIAN = "hr";
    public const CZECH = "cs";
    public const DANISH = "da";
    public const DUTCH = "nl";
    public const ESTONIAN = "et";
    public const FILIPINO = "fil";
    public const FINNISH = "fi";
    public const FRENCH = "fr";
    public const GERMAN = "de";
    public const GREEK = "el";
    public const GUJARATI = "gu";
    public const HEBREW = "iw";
    public const HINDI = "hi";
    public const HUNGARIAN = "hu";
    public const ICELANDIC = "is";
    public const INDONESIAN = "id";
    public const ITALIAN = "it";
    public const JAPANESE = "ja";
    public const KANNADA = "kn";
    public const KOREAN = "ko";
    public const LATVIAN = "lv";
    public const LITHUANIAN = "lt";
    public const MALAY = "ms";
    public const MALAYALAM = "ml";
    public const MARATHI = "mr";
    public const NORWEGIAN = "no";
    public const POLISH = "pl";
    public const PORTUGUESE_PORTUGAL = "pt-PT";
    public const ROMANIAN = "ro";
    public const RUSSIAN = "ru";
    public const SERBIAN = "sr";
    public const CHINESE_PRC = "zh-CN";
    public const SLOVAK = "sk";
    public const SLOVENIAN = "sl";
    public const SPANISH = "es";
    public const SWAHILI = "sw";
    public const SWEDISH = "sv";
    public const TAMIL = "ta";
    public const TELUGU = "te";
    public const THAI = "th";
    public const CHINESE_TAIWAN = "zh-TW";
    public const TURKISH = "tr";
    public const URDU = "ur";
    public const UKRAINIAN = "uk";
    public const VIETNAMESE = "vi";
    public const WELSH = "cy";

    public static function TranslateMessage(string $language, string $content, ?string $origin): void {
        ThreadManager::addRequest([$language], $content, $origin);
    }

    public static function TranslateMessages(array $languages, string $content, ?string $username = null, ?string $origin = null): void {
        ThreadManager::addRequest($languages, $content, $username, $origin);
    }

    public static function updatePlayerLanguage(string $name, string $lang): void {
        Loader::$players[strtolower($name)] = $lang;
    }

    public static function getPlayerLanguage(string $name): ?string {
        if(!isset(Loader::$players[strtolower($name)])) return null;
        return Loader::$players[strtolower($name)];
    }
}