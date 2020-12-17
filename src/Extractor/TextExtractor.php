<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Extractor;

use finfo;
use RuntimeException;
use SplFileObject;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyInterface;
use Xatham\TextExtraction\Factory\SourceFileObjectFactory;
use Xatham\TextExtraction\Resolver\MimeTypeResolver;

class TextExtractor implements TextExtractorInterface
{
    private TextExtractionConfiguration $textExtractionConfiguration;

    private MimeTypeResolver $mimeTypeResolver;

    private SourceFileObjectFactory $sourceFileObjectFactory;
    /**
     * @var ExtractionStrategyInterface[]
     */
    private array $extractionStrategies;

    public function __construct(
        TextExtractionConfiguration $textExtractionConfiguration,
        MimeTypeResolver $mimeTypeResolver,
        SourceFileObjectFactory $sourceFileObjectFactory,
        ExtractionStrategyInterface... $extractionStrategies
    ) {
        $this->textExtractionConfiguration = $textExtractionConfiguration;
        $this->mimeTypeResolver = $mimeTypeResolver;
        $this->sourceFileObjectFactory = $sourceFileObjectFactory;
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
        $splFileObject = $this->sourceFileObjectFactory->getExtractableFileObject($filePath);
        $mimeType = $this->mimeTypeResolver->getMimeTypeForTextSource($splFileObject);

        foreach ($this->extractionStrategies as $strategy) {
            if ($strategy->canHandle($mimeType, $this->textExtractionConfiguration) === false) {
                continue;
            }
            return $strategy->extractSource($splFileObject, $this->textExtractionConfiguration);
        }

        return null;
    }
}
