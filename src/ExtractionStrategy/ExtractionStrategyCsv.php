<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;

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
        $fileObject->rewind();

        while ($fileObject->eof() === false) {
            $row = $fileObject->fgetcsv();
            if (is_array($row) === false) {
                throw new \RuntimeException('Could not parse csv file');
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
