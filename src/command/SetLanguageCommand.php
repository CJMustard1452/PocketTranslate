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

namespace CJMustard1452\translate\command;

use CJMustard1452\translate\Loader;
use CJMustard1452\translate\PocketTranslate;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use ReflectionClass;
use function implode;
use function in_array;

class SetLanguageCommand extends Command implements PluginOwned {

	private Loader $plugin;
	private string $sorted;
	private array $lang = [];

	public function __construct(Loader $loader) {
		$this->plugin = $loader;

		parent::__construct("setlanguage", "Translation language selection.");
		$this->setPermission('pockettranslate.setlanguage.cmd');

		$pt = new ReflectionClass(PocketTranslate::class);

		$sorted = [];
		foreach($pt->getConstants() as $name => $key) {
			$this->lang[] = $key;
			$sorted[] = $name . " => " . $key . "\n";
		}

		$this->sorted = "§c" . implode($sorted);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : void {
		if(!$sender instanceof Player) {
			$sender->sendMessage("You can only use this command in game...");
			return;
		}

		if(!isset($args[0])) {
			$sender->sendMessage("Please enter a language code:\n$this->sorted");
			return;
		}

		if(!in_array($args[0], $this->lang, true)) {
			$sender->sendMessage("Please enter a language valid code:\n$this->sorted");
			return;
		}

		PocketTranslate::updatePlayerLanguage($sender->getName(), $args[0]);

		$sender->sendMessage("Your language has been updated.");
	}

	public function getOwningPlugin() : Loader {
		return $this->plugin;
	}
}
