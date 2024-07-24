<?php

namespace CJMustard1452\translate;

use CJMustard1452\translate\command\SetLanguageCommand;
use CJMustard1452\translate\listener\TranslationListener;
use CJMustard1452\translate\task\CheckAPIKeyTask;
use CJMustard1452\translate\task\InvalidKeyTask;
use CJMustard1452\translate\thread\ThreadManager;
use pocketmine\utils\SingletonTrait;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Loader extends PluginBase {
    use SingletonTrait;

    public static array $config = [];
    public static array $players = [];

    public function onEnable(): void {
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

    public static function enable(): void {
        $instance = self::getInstance();

        new ThreadManager();
        new PocketTranslate();

        $instance->getServer()->getPluginManager()->registerEvents(new TranslationListener(), $instance);
        $instance->getServer()->getCommandMap()->register("pockettranslate", new SetLanguageCommand($instance));
    }

    public function onDisable(): void {
        $config = new Config($this->getDataFolder() . 'config.yml');
        $config->setAll([
            "config" => self::$config,
            "players" => self::$players
        ]);

        $config->save();

        ThreadManager::shutdown();
    }
}
