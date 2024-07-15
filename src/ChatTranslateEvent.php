<?php

namespace CJMustard1452\translate;

use pocketmine\event\Event;

class ChatTranslateEvent extends Event {

    /**
	 * @param string $language      The language the message has been translated to.
	 * @param string $content       The post translated content.
     * @param string $origin        The origin language.
	 * @param string|null $username The players username
	 */
    public function __construct(
        private string $language,
        private string $content,
        private string $origin,
        private ?string $username
    ) { }

    public function getLanguage(): string {
        return $this->language;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function getOrigin(): string {
        return $this->origin;
    }

    public function getUsername(): ?string {
        return $this->username;
    }
}