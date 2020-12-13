<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;

use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\Dto\TextItem;
use Xatham\TextExtraction\Dto\TextSource;

class ExtractionStrategyTextFile implements ExtractionStrategyInterface
{
    private const MIME_TYPE_PDF = 'text/plain';

    public function extractSource(SplFileObject $fileObject, TextExtractionConfiguration $textExtractionConfiguration): ?Document
    {
        $document = new Document();
        $text = file_get_contents($fileObject->getPath()());
        $document->setTextItems([new TextItem($text)]);

        return $document;
    }

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool
    {
        return $mimeType === self::MIME_TYPE_PDF;
    }
}
