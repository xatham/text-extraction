<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;

use SimpleXLSX;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\Dto\TextSource;

class ExtractionStrategyExcel implements ExtractionStrategyInterface
{
    private const MIME_TYPE_EXCEL = 'application/vnd.ms-excel';

    public function extractSource(TextSource $textSource): ?Document
    {
        $document = new Document();
        $rows = SimpleXLSX::parse($textSource->getPath());
        $document->setTextItems([$rows]);

        return $document;
    }

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool
    {
        return $mimeType === self::MIME_TYPE_EXCEL;
    }
}
