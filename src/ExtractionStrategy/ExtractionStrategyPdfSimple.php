<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;

use Smalot\PdfParser\Parser;
use SplFileObject;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;

class ExtractionStrategyPdfSimple implements ExtractionStrategyInterface
{
    private const MIME_TYPE_PDF = 'application/pdf';

    private Parser $pdfParser;

    public function __construct(Parser $pdfParser)
    {
        $this->pdfParser = $pdfParser;
    }

    public function extractSource(SplFileObject $fileObject, TextExtractionConfiguration $textExtractionConfiguration): ?Document
    {
        $content = $fileObject->fpassthru();
        $parsedDocument = $this->pdfParser->parseContent($content);

        return (new Document())->setTextItems([$parsedDocument->getText()]);
    }

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool
    {
        return
            $mimeType === self::MIME_TYPE_PDF &&
            $configuration->isWithOCRSupport() !== true;
    }
}
