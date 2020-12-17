<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Extractor;

use finfo;
use RuntimeException;
use SplFileObject;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyInterface;

class TextExtractor implements TextExtractorInterface
{
    private TextExtractionConfiguration $textExtractionConfiguration;

    /**
     * @var ExtractionStrategyInterface[]
     */
    private array $extractionStrategies;

    public function __construct(
        TextExtractionConfiguration $textExtractionConfiguration,
        ExtractionStrategyInterface... $extractionStrategies
    ) {
        $this->textExtractionConfiguration = $textExtractionConfiguration;
        $this->extractionStrategies = $extractionStrategies;
    }

    public function extractByFilePath(string $filePath): ?Document
    {
        if (
            $this->textExtractionConfiguration->isWithOCRSupport() === true &&
            extension_loaded('imagick') === false
        ) {
            throw new RuntimeException('Imagick PHP-Extension is required to use OCR');
        }
        $splFileObject = new SplFileObject($filePath, 'rb');
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($splFileObject->getRealPath());
        $splFileObject->rewind();

        foreach ($this->extractionStrategies as $strategy) {
            if ($strategy->canHandle($mimeType, $this->textExtractionConfiguration) === false) {
                continue;
            }
            return $strategy->extractSource($splFileObject, $this->textExtractionConfiguration);
        }

        return null;
    }
}
