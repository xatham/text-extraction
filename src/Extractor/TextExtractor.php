<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Extractor;

use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\Dto\TextSource;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyInterface;
use Xatham\TextExtraction\Resolver\MimeTypeResolver;

class TextExtractor implements TextExtractorInterface
{
    private TextExtractionConfiguration $textExtractionConfiguration;

    /**
     * @var ExtractionStrategyInterface[]
     */
    private array $extractionStrategies;

    private MimeTypeResolver $mimeTypeResolver;

    public function __construct(TextExtractionConfiguration $textExtractionConfiguration, $extractionStrategies, MimeTypeResolver $mimeTypeResolver)
    {
        $this->textExtractionConfiguration = $textExtractionConfiguration;
        $this->extractionStrategies = $extractionStrategies;
        $this->mimeTypeResolver = $mimeTypeResolver;
    }

    public function extractByFilePath(string $filePath): ?Document
    {
        $source = new TextSource($filePath);
        $mimeType = $this->mimeTypeResolver->getMimeTypeForTextSource($source);

        foreach ($this->extractionStrategies as $strategy) {
            if ($strategy->canHandle($mimeType, $this->textExtractionConfiguration) === false) {
                continue;
            }
            return $strategy->extractSource($source);
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
            return $strategy->extractSource($source);
        }
        return null;
    }
}
