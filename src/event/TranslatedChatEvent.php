<?php

namespace CJMustard1452\translate\event;

use CJMustard1452\translate\PocketTranslate;

class TranslatedChatEvent {

    public function __construct(
        public string $language,
        public string $content,
        public ?string $username
    ) {
        PocketTranslate::executeListeners($this);
    }
}