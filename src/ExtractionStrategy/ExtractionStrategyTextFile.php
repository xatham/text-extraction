<?php

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
