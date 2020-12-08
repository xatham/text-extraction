<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;

use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\Dto\TextSource;

class ExtractionStrategyCsv implements ExtractionStrategyInterface
{
    private const MIME_TYPE = 'text/csv';

    public function extractSource(TextSource $textSource): ?Document
    {
        $document = new Document();
        $fileHandle = fopen($textSource->getPath(), "rb");
        $texts = [];
        while (($rows = fgetcsv($fileHandle)) !== false) {
            foreach ($rows as $row) {
                $texts[] = $row;
            }
        }
        $document->setTextItems($texts);

        return $document;
    }

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool
    {
        return $mimeType === self::MIME_TYPE;
    }
}
