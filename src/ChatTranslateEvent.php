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

use pocketmine\event\Event;

class ChatTranslateEvent extends Event {

	/**
	 * @param string      $language The language the message has been translated to.
	 * @param string      $content  The post translated content.
	 * @param string      $origin   The origin language.
	 * @param string|null $username The players username
	 */
	public function __construct(
		private string $language,
		private string $content,
		private string $origin,
		private ?string $username
	) { }

	public function getLanguage() : string {
		return $this->language;
	}

	public function getContent() : string {
		return $this->content;
	}

	public function getOrigin() : string {
		return $this->origin;
	}

	public function getUsername() : ?string {
		return $this->username;
	}
}
