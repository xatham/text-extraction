<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Factory\ExtractionStrategy;

use Smalot\PdfParser\Parser;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyPdfSimple;

class ExtractionStrategyPDFSimpleFactory implements ExtractionStrategyFactoryInterface
{
    public function create(): ExtractionStrategyPdfSimple
    {
        return new ExtractionStrategyPDFSimple(
            new Parser()
        );
    }
}
