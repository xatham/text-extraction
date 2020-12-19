<?php

/**
 * This file is part of the xatham/text-extraction package.
 *
 * (c) Xatham <s.kirejewski@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

declare(strict_types=1);

use Xatham\TextExtraction\Builder\TextExtractionBuilder;

require dirname(__DIR__). '/vendor/autoload.php';

$textExtractor = (new TextExtractionBuilder())->buildTextExtractor(
    [
        'with_ocr' => false,
        'valid_mime_types' =>  ['application/pdf'],
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
