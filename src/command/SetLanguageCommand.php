<?php

namespace CJMustard1452\translate\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use CJMustard1452\translate\Loader;
use CJMustard1452\translate\PocketTranslate;

class SetLanguageCommand extends Command implements PluginOwned {

    private Loader $plugin;
    private array $lang = ["en", "es", "fr", "zh-TW", "zh-CN", "uk", "tr", "sv", "ru", "iw", "de", "fil", "ar", "nl"];

    public function __construct(Loader $loader) {
        $this->plugin = $loader;

        parent::__construct("setlanguage", "Translation language selection.");
        $this->setPermission('setlanguage.cmd');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if(!$sender instanceof Player) {
            $sender->sendMessage("You can only use this command in game...");
            return;
        }

        if(!isset($args[0])) {
            $sender->sendMessage("Please enter a language code\n" . implode(", ", $this->lang));
            return;
        }

        if(!in_array($args[0], $this->lang)) {
            if(!isset($args[0])) {
                $sender->sendMessage("Please enter a language valid code\n" . implode(", ", $this->lang));
                return;
            }
        }

        PocketTranslate::updatePlayerLanguage($sender->getName(), $args[0]);

        //yes this is in english :skull: i get the irony
        $sender->sendMessage("Your language has been updated.");
    }

    public function getOwningPlugin(): Loader {
		return $this->plugin;
	}
}