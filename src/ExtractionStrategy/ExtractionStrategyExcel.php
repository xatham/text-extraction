<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;

use ErrorException;
use SimpleXLSX;
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
        $content = $this->simpleXLSX->parse($fileObject->getPath());
        if (!$content instanceof SimpleXLSX) {
            throw new ErrorException('Could not parse Excel file');
        }
        /** @var SimpleXLSX $content */
        $rows = $content->rows();
        if (count($rows) === 0) {
            return $document;
        }
        $document->setTextItems($rows);

        return $document;
    }

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool
    {
        return $mimeType === self::MIME_TYPE_EXCEL;
    }
}
