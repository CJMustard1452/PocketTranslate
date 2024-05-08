<?php

namespace CJMustard1452\translate\listener;

use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use CJMustard1452\translate\PocketTranslate;
use pocketmine\event\Listener;
use pocketmine\Server;
use CJMustard1452\translate\Loader;

class TranslationListener implements Listener {

    public function onChat(PlayerChatEvent $playerChatEvent): void {
        $langs = [];
        foreach(Server::getInstance()->getOnlinePlayers() as $player) {
            $lang = PocketTranslate::getPlayerLanguage($player->getName());
            if(!isset($lang) || in_array($lang, $langs)) continue;

            $langs[] = $lang;
        }

        PocketTranslate::TranslateMessages($langs, $playerChatEvent->getMessage(), $lang);
    }

    public function onJoin(PlayerJoinEvent $playerJoinEvent): void {
        $lang = PocketTranslate::getPlayerLanguage($playerJoinEvent->getPlayer()->getName());
        if($lang == null) PocketTranslate::updatePlayerLanguage($playerJoinEvent->getPlayer()->getName(), Loader::$config['Default']);
    }
}