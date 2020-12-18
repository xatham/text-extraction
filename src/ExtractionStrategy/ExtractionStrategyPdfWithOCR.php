<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;

use League\Flysystem\Filesystem;
use SplFileObject;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Converter\ConvertPdfToImageFileConverter;
use Xatham\TextExtraction\Dto\Document;

class ExtractionStrategyPdfWithOCR implements ExtractionStrategyInterface
{
    private const MIME_TYPE_PDF = 'application/pdf';

    private TesseractOCR $pdfParser;

    private ConvertPdfToImageFileConverter $convertPdfToImageFileConverter;

    private Filesystem $fileSystem;

    public function __construct(TesseractOCR $pdfParser, ConvertPdfToImageFileConverter $convertPdfToImageFileConverter, Filesystem $fileSystem)
    {
        $this->pdfParser = $pdfParser;
        $this->convertPdfToImageFileConverter = $convertPdfToImageFileConverter;
        $this->fileSystem = $fileSystem;
    }

    public function extractSource(SplFileObject $fileObject, TextExtractionConfiguration $textExtractionConfiguration): ?Document
    {
        $imageFilePathArray = $this->convertPdfToImageFileConverter->convertPathTargetToImageFiles(
            $fileObject,
            'jpg',
            $textExtractionConfiguration->getTempDir()
        );
        try {
            $parsedContentArray = [];
            foreach ($imageFilePathArray as $imageFilePath) {
                $parsedContentArray[] = $this->pdfParser
                    ->image($imageFilePath)
                    ->run();
            }
            $parsedContent = implode("\n", $parsedContentArray);
        } finally {
            $this->cleanUpGeneratedFiles($imageFilePathArray, $textExtractionConfiguration->getTempDir());
        }

        return (new Document())->setTextItems([$parsedContent]);
    }

    /**
     * @param string[] $fileNames
     */
    private function cleanUpGeneratedFiles(array $fileNames, string $tempDir): void
    {
        foreach ($fileNames as $fileName) {
            $this->fileSystem->delete(str_replace($tempDir . '/', '', $fileName));
        }
    }

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool
    {
        return
            $mimeType === self::MIME_TYPE_PDF &&
            $configuration->isWithOCRSupport() === true &&
            $configuration->getTempDir() !== null;
    }
}
