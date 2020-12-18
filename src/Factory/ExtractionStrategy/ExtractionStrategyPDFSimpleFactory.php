<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Factory\ExtractionStrategy;

use Smalot\PdfParser\Parser;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyPdfSimple;

class ExtractionStrategyPDFSimpleFactory implements ExtractionStrategyFactoryInterface
{
    public function create(TextExtractionConfiguration $textExtractionConfiguration): ExtractionStrategyPdfSimple
    {
        return new ExtractionStrategyPDFSimple(
            new Parser()
        );
    }
}
