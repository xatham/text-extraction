<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Factory\ExtractionStrategy;

use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyTextFile;

class ExtractionStrategyTextFileFactory implements ExtractionStrategyFactoryInterface
{
    public function create(): ExtractionStrategyTextFile
    {
        return new ExtractionStrategyTextFile();
    }
}
