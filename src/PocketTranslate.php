<?php

/*
 *
 *  ____     ___     ____   _  __  _____   _____   _____   ____       _      _   _   ____    _          _      _____   _____
 * |  _ \   / _ \   / ___| | |/ / | ____| |_   _| |_   _| |  _ \     / \    | \ | | / ___|  | |        / \    |_   _| | ____|
 * | |_) | | | | | | |     | ' /  |  _|     | |     | |   | |_) |   / _ \   |  \| | \___ \  | |       / _ \     | |   |  _|
 * |  __/  | |_| | | |___  | . \  | |___    | |     | |   |  _ <   / ___ \  | |\  |  ___) | | |___   / ___ \    | |   | |___
 * |_|      \___/   \____| |_|\_\ |_____|   |_|     |_|   |_| \_\ /_/   \_\ |_| \_| |____/  |_____| /_/   \_\   |_|   |_____|
 *
 * Copyright 2024 CJMustard1452
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the “Software”),
 * to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @author CJMustard1452
 * @link https://github.com/CJMustard1452/PocketTranslate
 *
 *
 */

declare(strict_types=1);

namespace CJMustard1452\translate;

use CJMustard1452\translate\thread\ThreadManager;
use function strtolower;

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

	public static function TranslateMessage(string $language, string $content, ?string $origin) : void {
		ThreadManager::addRequest([$language], $content, $origin);
	}

	public static function TranslateMessages(array $languages, string $content, ?string $username = null, ?string $origin = null) : void {
		ThreadManager::addRequest($languages, $content, $username, $origin);
	}

	public static function updatePlayerLanguage(string $name, string $lang) : void {
		Loader::$players[strtolower($name)] = $lang;
	}

	public static function getPlayerLanguage(string $name) : ?string {
		if(!isset(Loader::$players[strtolower($name)])) return null;
		return Loader::$players[strtolower($name)];
	}
}
