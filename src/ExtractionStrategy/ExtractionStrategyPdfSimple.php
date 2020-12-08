<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;

use App\BusinessLogic\Config\DocumentUploadConfig;
use App\BusinessLogic\Document\Parser\Model\ParsableModelInterface;
use App\BusinessLogic\Document\Parser\ParsingContext;
use Smalot\PdfParser\Parser;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\Dto\TextSource;

class ExtractionStrategyPdfSimple implements ExtractionStrategyInterface
{
    private const MIME_TYPE_PDF = 'application/pdf';

    /**
     * @var Parser
     */
    private $pdfParser;

    /** @var DocumentUploadConfig */
    private $documentUploadConfig;

    public function __construct(Parser $pdfParser, DocumentUploadConfig $documentUploadConfig)
    {
        $this->pdfParser = $pdfParser;
        $this->documentUploadConfig = $documentUploadConfig;
    }

    public function extractSource(TextSource $textSource): Document
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
        return $mimeType->getMimeType() === self::MIME_TYPE_PDF && $this->documentUploadConfig->isWithOCR() === false;
    }
}
