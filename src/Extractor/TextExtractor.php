<?php

/**
 * This file is part of the Xatham/text-extraction package.
 *
 * (c) Xatham <s.kirejewski@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Xatham\TextExtraction\Extractor;

use RuntimeException;
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
        ExtractionStrategyInterface ...$extractionStrategies
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
        $validMimeTypes = $this->textExtractionConfiguration->getValidMimeTypeCollection();
        $splFileObject = $this->sourceFileObjectFactory->getExtractableFileObject($filePath);
        $mimeType = $this->mimeTypeResolver->getMimeTypeForTextSource($splFileObject);

        if (count($validMimeTypes) > 0 && in_array($mimeType, $validMimeTypes, true) === false) {
            throw new RuntimeException(sprintf('Mimetype of type %s is not valid. Please adjust valid mimetypes or use different document', $mimeType));
        }

        foreach ($this->extractionStrategies as $strategy) {
            if ($strategy->canHandle($mimeType, $this->textExtractionConfiguration) === false) {
                continue;
            }

            return $strategy->extractSource($splFileObject, $this->textExtractionConfiguration);
        }

        return null;
    }
}
