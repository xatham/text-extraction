![PHP Composer](https://github.com/xatham/text-extraction/workflows/PHP%20Composer/badge.svg)

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

/**
 * Extracting only pdf files, without ocr capturing
 */
$textExtractor = (new TextExtractionBuilder())->buildTextExtractor(
    [
        'withOcr' => false,
        'validMimeTypes' =>  ['application/pdf'],
    ],
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

## License

text-extraction is licensed under [MIT](https://github.com/xatham/text-extraction/blob/main/LICENSE).
