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

namespace Xatham\TextExtraction\Builder;

use InvalidArgumentException;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Extractor\TextExtractor;
use Xatham\TextExtraction\Factory\ExtractionStrategy\ExtractionStrategyCsvFactory;
use Xatham\TextExtraction\Factory\ExtractionStrategy\ExtractionStrategyExcelFactory;
use Xatham\TextExtraction\Factory\ExtractionStrategy\ExtractionStrategyOpenDocumentFactory;
use Xatham\TextExtraction\Factory\ExtractionStrategy\ExtractionStrategyPDFSimpleFactory;
use Xatham\TextExtraction\Factory\ExtractionStrategy\ExtractionStrategyPDFWithOCRFactory;
use Xatham\TextExtraction\Factory\ExtractionStrategy\ExtractionStrategyTextFileFactory;
use Xatham\TextExtraction\Factory\ExtractionStrategy\ExtractionStrategyWordDocFactory;
use Xatham\TextExtraction\Factory\SourceFileObjectFactory;
use Xatham\TextExtraction\Resolver\MimeTypeResolver;

final class TextExtractionBuilder
{
    /**
     * @param array<string, mixed> $configuration
     */
    public function buildTextExtractor(array $configuration): TextExtractor
    {

        // pagination currently not supported
        $pagination = $configuration['pagination'] ?? false;
        $withOcr = $configuration['withOcr'] ?? false;
        $tempDir = $configuration['tempDir'] ?? sys_get_temp_dir();
        $mimeTypeSettings = $configuration['mimeTypeSettings'] ?? [];
        $validMimeTypes = $this->extractValidMimeTypes($configuration);

        $textExtractionConfiguration = new TextExtractionConfiguration(
            $withOcr,
            $pagination,
            $tempDir,
            $mimeTypeSettings,
            $validMimeTypes
        );

        $factories = [
            ExtractionStrategyCsvFactory::class,
            ExtractionStrategyExcelFactory::class,
            ExtractionStrategyPDFSimpleFactory::class,
            ExtractionStrategyPDFWithOCRFactory::class,
            ExtractionStrategyOpenDocumentFactory::class,
            ExtractionStrategyTextFileFactory::class,
            ExtractionStrategyWordDocFactory::class,
        ];

        $strategies = [];
        foreach ($factories as $factory) {
            $strategies[] = (new $factory())->create($textExtractionConfiguration);
        }

        return new TextExtractor(
            $textExtractionConfiguration,
            new MimeTypeResolver(),
            new SourceFileObjectFactory(),
            ...$strategies
        );
    }

    /**
     * @param array<string, mixed> $configuration
     *
     * @return string[]
     */
    private function extractValidMimeTypes(array $configuration): array
    {
        $validMimeTypes = $configuration['validMimeTypes'] ?? null;
        if ($validMimeTypes === null) {
            return [];
        }
        if (is_array($validMimeTypes) === false) {
            throw new InvalidArgumentException('validMimeTypes expects an array');
        }

        return $validMimeTypes;
    }
}
