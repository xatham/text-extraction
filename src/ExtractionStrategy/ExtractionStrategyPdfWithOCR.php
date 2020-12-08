<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;
use App\BusinessLogic\Config\DocumentUploadConfig;
use App\BusinessLogic\Document\Converter\ConvertPdfToImageFileConverter;
use App\BusinessLogic\Document\Enum\ExtensionType;
use App\BusinessLogic\Document\Parser\Model\ParsableModelInterface;
use App\BusinessLogic\Document\Parser\ParsingContext;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\Dto\TextSource;

class ExtractionStrategyPdfWithOCR implements ExtractionStrategyInterface
{
    private const MIME_TYPE_PDF = 'application/pdf';

    /**
     * @var TesseractOCR
     */
    private $pdfParser;

    /** @var DocumentUploadConfig */
    private $documentUploadConfig;

    /** @var ConvertPdfToImageFileConverter */
    private $convertPdfToImageFileConverter;

    public function __construct(TesseractOCR $pdfParser, DocumentUploadConfig $documentUploadConfig, ConvertPdfToImageFileConverter $convertPdfToImageFileConverter)
    {
        $this->pdfParser = $pdfParser;
        $this->documentUploadConfig = $documentUploadConfig;
        $this->convertPdfToImageFileConverter = $convertPdfToImageFileConverter;
    }

    public function extractSource(TextSource $textSource): Document
    {
        $imageFilePathArray = $this->convertPdfToImageFileConverter->convertToImageFiles(
            $parsingContext->getDocumentPath(),
            ExtensionType::IMAGE_JPG()
        );

        $parsedContentArray = [];

        foreach ($imageFilePathArray as $imageFilePath) {
            $parsedContentArray[] = $this->pdfParser
                ->image($imageFilePath)
                ->run();
        }

        $parsedContent = implode("\n", $parsedContentArray);
        $parsableModel->setPlainTexts([$parsedContent]);

        return $parsableModel;
    }

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool
    {
        return $mimeType->getMimeType() === self::MIME_TYPE_PDF && $this->documentUploadConfig->isWithOCR() === true;
    }
}
