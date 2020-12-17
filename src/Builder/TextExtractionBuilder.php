<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Builder;

use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Extractor\TextExtractor;
use Xatham\TextExtraction\Factory\ExtractionStrategy\ExtractionStrategyCsvFactory;
use Xatham\TextExtraction\Factory\ExtractionStrategy\ExtractionStrategyExcelFactory;
use Xatham\TextExtraction\Factory\ExtractionStrategy\ExtractionStrategyOpenDocumentFactory;
use Xatham\TextExtraction\Factory\ExtractionStrategy\ExtractionStrategyPDFSimpleFactory;
use Xatham\TextExtraction\Factory\ExtractionStrategy\ExtractionStrategyPDFWithOCRFactory;
use Xatham\TextExtraction\Factory\ExtractionStrategy\ExtractionStrategyTextFileFactory;
use Xatham\TextExtraction\Factory\ExtractionStrategy\ExtractionStrategyWordDocFactory;

final class TextExtractionBuilder
{
    public function buildTextExtractor(TextExtractionConfiguration $textExtractionConfiguration): TextExtractor
    {
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
            $strategies[] = (new $factory())->create();
        }

        return new TextExtractor($textExtractionConfiguration, ...$strategies);
    }
}
