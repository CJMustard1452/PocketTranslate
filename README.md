# PocketTranslate Plugin for PocketMine-MP v5

PocketTranslate is a plugin for PocketMine-MP v5, designed to facilitate live chat translations within your server using the Google Cloud Translation API. With PocketTranslate, developers can seamlessly integrate translation capabilities into their plugins, enhancing communication and accessibility for players from different linguistic backgrounds.

## Features

- **Live Chat Translation**: Translate messages in real-time within the server chat.
- **Multiple Language Support**: Translate messages to and from various languages supported by the Google Cloud Translation API.
- **Developer-Friendly API**: Simple and intuitive API for developers to integrate translation features into their plugins effortlessly.

## Requirements

- PocketMine-MP v5
- Google Cloud Translation API key

## Installation

1. Download the latest release of PocketTranslate from the [GitHub repository](https://github.com/example/repository).
2. Place the `PocketTranslate.phar` file into the `plugins` directory of your PocketMine-MP server.
3. Restart or reload your server.

## Configuration

1. Generate a Google Cloud Translation API key from the [Google Cloud Console](https://console.cloud.google.com).
2. Open the `config.yml` file located in the `plugins/PocketTranslate` directory.
3. Enter your Google Cloud Translation API key in the `api_key` field.

## Usage

### Translate a Message

```php
use CJMustard1452\translate\PocketTranslate

$handler = function($data) {
  //Handle $data
};

PocketTranslate::RegisterListener($handler);
```
