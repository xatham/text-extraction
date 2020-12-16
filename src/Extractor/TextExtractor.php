<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Extractor;

use League\Flysystem\Filesystem;
use RuntimeException;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\Dto\TextSource;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyInterface;
use Xatham\TextExtraction\Resolver\MimeTypeResolver;

class TextExtractor implements TextExtractorInterface
{
    private Filesystem $fileSystem;

    private TextExtractionConfiguration $textExtractionConfiguration;

    /**
     * @var ExtractionStrategyInterface[]
     */
    private array $extractionStrategies;

    public function __construct(
        Filesystem $filesystem,
        TextExtractionConfiguration $textExtractionConfiguration,
        array $extractionStrategies,
        MimeTypeResolver $mimeTypeResolver
    ) {
        $this->fileSystem = $filesystem;
        $this->textExtractionConfiguration = $textExtractionConfiguration;
        $this->extractionStrategies = $extractionStrategies;
        $this->mimeTypeResolver = $mimeTypeResolver;
    }

    private MimeTypeResolver $mimeTypeResolver;

    public function extractByFilePath(string $filePath): ?Document
    {
        if (
            $this->textExtractionConfiguration->isWithOCRSupport() === true &&
            extension_loaded('imagick') === false
        ) {
            throw new RuntimeException('Imagick PHP-Extension is required to use OCR');
        }
        $mimeType = $filePath = $this->fileSystem->mimeType($filePath);
        $source = new TextSource($filePath);

        foreach ($this->extractionStrategies as $strategy) {
            if ($strategy->canHandle($mimeType, $this->textExtractionConfiguration) === false) {
                continue;
            }
            return $strategy->extractSource($source,);
        }

        return null;
    }

    public function extractByString(string $string): ?Document
    {
        $source = new TextSource(null, $string);
        $mimeType = $this->mimeTypeResolver->getMimeTypeForTextSource($source);

        foreach ($this->extractionStrategies as $strategy) {
            if ($strategy->canHandle($mimeType, $this->textExtractionConfiguration) === false) {
                continue;
            }
            return $strategy->extractSource($source,);
        }
        return null;
    }
}
