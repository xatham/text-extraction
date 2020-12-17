<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Factory\ExtractionStrategy;

use SimpleXLSX;
use Xatham\TextExtraction\Decorator\SimpleXLSXDecorator;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyExcel;

class ExtractionStrategyExcelFactory implements ExtractionStrategyFactoryInterface
{
    public function create(): ExtractionStrategyExcel
    {
        return new ExtractionStrategyExcel(
            new SimpleXLSXDecorator(
                new SimpleXLSX()
            )
        );
    }
}
