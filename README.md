# PocketTranslate Plugin for PocketMine-MP v5
[![](https://poggit.pmmp.io/shield.api/PocketTranslate)](https://poggit.pmmp.io/p/PocketTranslate)
[![](https://poggit.pmmp.io/shield.state/PocketTranslate)](https://poggit.pmmp.io/p/PocketTranslate)
[![](https://poggit.pmmp.io/shield.dl.total/PocketTranslate)](https://poggit.pmmp.io/p/PocketTranslate)

PocketTranslate is a plugin for PocketMine-MP v5, designed to facilitate live chat translations within your server using the Google Cloud Translation API. With PocketTranslate, developers can seamlessly integrate translation capabilities into their plugins, enhancing communication and accessibility for players from different linguistic backgrounds.

## Features

- **Live Chat Translation**: Translate messages in real-time within the server chat.
- **Multiple Language Support**: Translate messages to and from various languages supported by the Google Cloud Translation API.
- **Developer-Friendly API**: Simple and intuitive API for developers to integrate translation features into their plugins effortlessly.

## Requirements

- PocketMine-MP v5
- Google Cloud Translation API key

## Installation

1. Download the latest release of PocketTranslate from the [GitHub repository]([https://github.com/example/repository](https://github.com/CJMustard1452/PocketTranslate)).
2. Place the `PocketTranslate.phar` file into the `plugins` directory of your PocketMine-MP server.
3. Restart or reload your server.

## Configuration

1. Generate a Google Cloud Translation API key from the [Google Cloud Console](https://console.cloud.google.com).
2. Open the `config.yml` file located in the `plugin_data/PocketTranslate` directory.
3. Enter your Google Cloud Translation API key in the `APIKey` field.

## Usage

### Add ChatTranslationEvent to your listener.

```php
use CJMustard1452\translate\ChatTranslateEvent;

/**
	* @param string $chatTranslateEvent->getLanguage()      The language the message has been translated to.
	* @param string $chatTranslateEvent->getContent()       The post translated content.
	* @param string $chatTranslateEvent->getOrigin()        The origin language.
	* @param string|null $chatTranslateEvent->getUsername() The players username
*/
public function onTranslate(ChatTranslateEvent $chatTranslateEvent): void {
	// handle $chatTranslateEvent
};
```

## Supported Languages
```
English (US) => en
Amharic => am
Arabic => ar
Basque => eu
Bengali => bn
English (UK) => en-GB
Portuguese (Brazil) => pt-BR
Bulgarian => bg
Catalan => ca
Cherokee => chr
Croatian => hr
Czech => cs
Danish => da
Dutch => nl
Estonian => et
Filipino => fil
Finnish => fi
French => fr
German => de
Greek => el
Gujarati => gu
Hebrew => iw
Hindi => hi
Hungarian => hu
Icelandic => is
Indonesian => id
Italian => it
Japanese => ja
Kannada => kn
Korean => ko
Latvian => lv
Lithuanian => lt
Malay => ms
Malayalam => ml
Marathi => mr
Norwegian => no
Polish => pl
Portuguese (Portugal) => pt-PT
Romanian => ro
Russian => ru
Serbian => sr
Chinese (PRC) => zh-CN
Slovak => sk
Slovenian => sl
Spanish => es
Swahili => sw
Swedish => sv
Tamil => ta
Telugu => te
Thai => th
Chinese (Taiwan) => zh-TW
Turkish => tr
Urdu => ur
Ukrainian => uk
Vietnamese => vi
Welsh => cy
```
