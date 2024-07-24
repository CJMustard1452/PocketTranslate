<?php

namespace CJMustard1452\translate\command;

use CJMustard1452\translate\PocketTranslate;
use pocketmine\command\CommandSender;
use CJMustard1452\translate\Loader;
use pocketmine\plugin\PluginOwned;
use pocketmine\command\Command;
use pocketmine\player\Player;
use ReflectionClass;

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

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if(!$sender instanceof Player) {
            $sender->sendMessage("You can only use this command in game...");
            return;
        }

        if(!isset($args[0])) {
            $sender->sendMessage("Please enter a language code:\n$this->sorted");
            return;
        }

        if(!in_array($args[0], $this->lang)) {
            $sender->sendMessage("Please enter a language valid code:\n$this->sorted");
            return;
        }

        PocketTranslate::updatePlayerLanguage($sender->getName(), $args[0]);

        //yes this is in english :skull: i get the irony
        $sender->sendMessage("Your language has been updated.");
    }

    public function getOwningPlugin(): Loader {
		return $this->plugin;
	}
}