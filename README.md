# text-extraction

## About

This PHP-Library let's you extract plain text from various document types.

Currently supported file mime-types for extraction are:

`text/plain`

`text/csv`

`application/vnd.ms-excel`

`application/vnd.oasis.opendocument.text`

`application/pdf`

`application/msword'`

## Install

```bash
composer require xatham/text-extraction
```

## Usage

```php

$textExtractor = (new TextExtractionBuilder())->buildTextExtractor(
    new TextExtractionConfiguration(
        '/tmp',
        false,
    )
);

$target = dirname(__DIR__) . '/examples/sample.pdf';
$plainTextDocument = $textExtractor->extractByFilePath($target);
if ($plainTextDocument === null) {
    exit('Could not extract any data');
}
$texts = $plainTextDocument->getTextItems();

foreach ($texts as $text) {
    var_dump($text);
}

```
