<?php

/**
 * This file is part of the Xatham/text-extraction package.
 *
 * (c) Xatham <s.kirejewski@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;

use SplFileObject;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;

class ExtractionStrategyTextFile implements ExtractionStrategyInterface
{
    private const MIME_TYPE_PDF = 'text/plain';

    public function extractSource(SplFileObject $fileObject, TextExtractionConfiguration $textExtractionConfiguration): ?Document
    {
        $content = '';
        while ($fileObject->eof() === false) {
            $content .= $fileObject->fgets();
        }

        $document = new Document();
        $document->setTextItems([$content]);

        return $document;
    }

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool
    {
        return $mimeType === self::MIME_TYPE_PDF;
    }
}
