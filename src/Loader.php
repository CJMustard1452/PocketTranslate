<?php

namespace CJMustard1452\translate;

use CJMustard1452\translate\command\SetLanguageCommand;
use CJMustard1452\translate\listener\TranslationListener;
use CJMustard1452\translate\thread\ThreadManager;
use pocketmine\scheduler\ClosureTask;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Loader extends PluginBase {

    public static array $config = [];
    public static array $players = [];

    public function onEnable(): void {
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
            $this->missingKey();
            return;
        }

        new ThreadManager($this);
        new PocketTranslate();

        $this->getServer()->getPluginManager()->registerEvents(new TranslationListener(), $this);
        $this->getServer()->getCommandMap()->register("pockettranslate", new SetLanguageCommand($this));
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

    private function missingKey(): void {
        $this->getLogger()->notice("Missing Google Translate API Key...
        - If you already have one, please insert it into ./plugin_data/PocketTranslate/config.yml
        - If you don't have a key yet, find out how to get one by visiting https://cloud.google.com/translate/.");

        $this->getScheduler()->scheduleDelayedTask(new ClosureTask(function() {
            $this->getServer()->getPluginManager()->disablePlugin($this);
        }), $this->getServer()->getTicksPerSecond());
    }
}
