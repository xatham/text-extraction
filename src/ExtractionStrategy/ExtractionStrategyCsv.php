<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;

use RuntimeException;
use SplFileObject;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;

class ExtractionStrategyCsv implements ExtractionStrategyInterface
{
    private const MIME_TYPE = 'text/csv';

    public function extractSource(SplFileObject $fileObject, TextExtractionConfiguration $textExtractionConfiguration): ?Document
    {
        $document = new Document();
        $text = '';
        $settings = $textExtractionConfiguration->getTypeSpecificSettings();
        $csvSettings = $settings[self::MIME_TYPE] ?? [];

        $fileObject->rewind();
        while ($fileObject->eof() === false) {
            $row = $fileObject->fgetcsv(
                $csvSettings['delimiter'] ?? ',',
                $csvSettings['enclosure'] ?? "\"",
                $csvSettings['escape'] ?? "\\",
            );
            if (is_array($row) === false) {
                throw new RuntimeException('Could not parse csv file');
            }
            $text .= trim(implode(' ', $row));
        }
        $document->setTextItems([$text]);

        return $document;
    }

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool
    {
        return $mimeType === self::MIME_TYPE;
    }
}
