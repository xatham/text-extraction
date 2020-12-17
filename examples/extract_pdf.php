<?php

declare(strict_types=1);

use Xatham\TextExtraction\Builder\TextExtractionBuilder;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;

require dirname(__DIR__). '/vendor/autoload.php';

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
