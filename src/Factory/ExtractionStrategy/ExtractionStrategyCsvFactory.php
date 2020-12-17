<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Factory\ExtractionStrategy;

use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyCsv;

class ExtractionStrategyCsvFactory implements ExtractionStrategyFactoryInterface
{
    public function create(): ExtractionStrategyCsv
    {
        return new ExtractionStrategyCsv();
    }
}
