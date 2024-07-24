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

use CJMustard1452\translate\command\SetLanguageCommand;
use CJMustard1452\translate\listener\TranslationListener;
use CJMustard1452\translate\task\CheckAPIKeyTask;
use CJMustard1452\translate\task\InvalidKeyTask;
use CJMustard1452\translate\thread\ThreadManager;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class Loader extends PluginBase {
	use SingletonTrait;

	public static array $config = [];
	public static array $players = [];

	public function onEnable() : void {
		self::setInstance($this);
		$config = new Config($this->getDataFolder() . 'config.yml');
		if(isset($config->getAll()['config'])) self::$config = $config->getAll()['config'];
		if(isset($config->getAll()['players'])) self::$players = $config->getAll()['players'];

		if (!isset(self::$config["APIKey"])) {
			self::$config["APIKey"] = false;
		}

		if (!isset(self::$config["Default"])) {
			self::$config["Default"] = 'en';
		}

		if (!self::$config["APIKey"]) {
			$this->getScheduler()->scheduleDelayedTask(new InvalidKeyTask(), $this->getServer()->getTicksPerSecond());
			return;
		}

		$this->getServer()->getAsyncPool()->submitTask(new CheckAPIKeyTask(self::$config["APIKey"]));
	}

	public static function enable() : void {
		$instance = self::getInstance();

		new ThreadManager();
		new PocketTranslate();

		$instance->getServer()->getPluginManager()->registerEvents(new TranslationListener(), $instance);
		$instance->getServer()->getCommandMap()->register("pockettranslate", new SetLanguageCommand($instance));
	}

	public function onDisable() : void {
		$config = new Config($this->getDataFolder() . 'config.yml');
		$config->setAll([
			"config" => self::$config,
			"players" => self::$players
		]);

		$config->save();

		ThreadManager::shutdown();
	}
}
