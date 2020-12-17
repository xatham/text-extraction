<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Factory\ExtractionStrategy;

use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyInterface;

interface ExtractionStrategyFactoryInterface
{
    public function create(): ExtractionStrategyInterface;
}
