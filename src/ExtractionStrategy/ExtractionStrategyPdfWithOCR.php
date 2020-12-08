<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;

use thiagoalessio\TesseractOCR\TesseractOCR;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Converter\ConvertPdfToImageFileConverter;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\Dto\TextSource;

class ExtractionStrategyPdfWithOCR implements ExtractionStrategyInterface
{
    private const MIME_TYPE_PDF = 'application/pdf';

    private TesseractOCR $pdfParser;

    private ConvertPdfToImageFileConverter $convertPdfToImageFileConverter;

    public function __construct(TesseractOCR $pdfParser, ConvertPdfToImageFileConverter $convertPdfToImageFileConverter)
    {
        $this->pdfParser = $pdfParser;
        $this->convertPdfToImageFileConverter = $convertPdfToImageFileConverter;
    }

    public function extractSource(TextSource $textSource): ?Document
    {
        $imageFilePathArray = $this->convertPdfToImageFileConverter->convertToImageFiles(
            $textSource->getPath(),
            'jpg'
        );

        $parsedContentArray = [];

        foreach ($imageFilePathArray as $imageFilePath) {
            $parsedContentArray[] = $this->pdfParser
                ->image($imageFilePath)
                ->run();
        }
        $parsedContent = implode("\n", $parsedContentArray);

        return (new Document())->setTextItems([$parsedContent]);
    }

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool
    {
        return $mimeType === self::MIME_TYPE_PDF && $configuration->isWithOCRSupport() !== true;
    }
}
