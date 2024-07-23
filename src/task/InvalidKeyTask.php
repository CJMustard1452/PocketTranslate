<?php

namespace CJMustard1452\translate\task;

use CJMustard1452\translate\Loader;
use pocketmine\scheduler\Task;

class InvalidKeyTask extends Task {

    public function __construct() {
        Loader::getInstance()->getLogger()->notice("Missing / Invalid Google Translate API Key...
        - If you already have one, please insert it into ./plugin_data/PocketTranslate/config.yml
        - If you don't have a key yet, find out how to get one by visiting https://console.cloud.google.com/apis/dashboard.");
    }

    public function onRun(): void {
        $instance = Loader::getInstance();
        $instance->getServer()->getPluginManager()->disablePlugin($instance);
    }
}