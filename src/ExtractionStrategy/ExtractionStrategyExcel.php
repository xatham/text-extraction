<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;

use ErrorException;
use SplFileObject;
use Xatham\TextExtraction\Decorator\SimpleXLSXDecorator;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;

class ExtractionStrategyExcel implements ExtractionStrategyInterface
{
    private const MIME_TYPE_EXCEL = 'application/vnd.ms-excel';

    private SimpleXLSXDecorator $simpleXLSX;

    public function __construct(SimpleXLSXDecorator $simpleXLSX)
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