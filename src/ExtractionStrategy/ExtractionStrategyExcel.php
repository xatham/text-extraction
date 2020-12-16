<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;

use ErrorException;
use SimpleXLSX;
use SplFileObject;
use Xatham\TextExtraction\Decorator\SimpleXLSCDecorator;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\Dto\TextSource;

class ExtractionStrategyExcel implements ExtractionStrategyInterface
{
    private const MIME_TYPE_EXCEL = 'application/vnd.ms-excel';

    private SimpleXLSCDecorator $simpleXLSX;

    public function __construct(SimpleXLSCDecorator $simpleXLSX)
    {
        $this->simpleXLSX = $simpleXLSX;
    }

    public function extractSource(SplFileObject $fileObject, TextExtractionConfiguration $textExtractionConfiguration): ?Document
    {
        $document = new Document();
        $rows = $this->simpleXLSX->parse($fileObject->getPath());
        if (!$rows) {
            throw new ErrorException('Could not parse Excel file');
        }
        $document->setTextItems([$rows]);

        return $document;
    }

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool
    {
        return $mimeType === self::MIME_TYPE_EXCEL;
    }
}
