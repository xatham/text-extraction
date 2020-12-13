<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;

use Smalot\PdfParser\Parser;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\Dto\TextSource;

class ExtractionStrategyPdfSimple implements ExtractionStrategyInterface
{
    private const MIME_TYPE_PDF = 'application/pdf';

    /**
     * @var Parser
     */
    private $pdfParser;

    public function __construct(Parser $pdfParser)
    {
        $this->pdfParser = $pdfParser;
    }

    public function extractSource(SplFileObject $fileObject, TextExtractionConfiguration $textExtractionConfiguration): ?Document
    {
        $content = $parsingContext->getDocumentPath();
        $plainText = file_get_contents($content);
        $parsedDocument = $this->pdfParser->parseContent($plainText);
        $parsableModel->setPlainTexts(
            [
                $parsedDocument->getText()
            ]
        );

        return $parsableModel;
    }

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool
    {
        return
            $mimeType === self::MIME_TYPE_PDF &&
            $configuration->isWithOCRSupport() !== true && $textSource->getPath() !== null;
    }
}
