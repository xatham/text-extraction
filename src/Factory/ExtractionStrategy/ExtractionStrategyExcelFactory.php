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

namespace Xatham\TextExtraction\Factory\ExtractionStrategy;

use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyExcel;
use Xatham\TextExtraction\Factory\SpreadSheetFactory;

class ExtractionStrategyExcelFactory implements ExtractionStrategyFactoryInterface
{
    public function create(TextExtractionConfiguration $textExtractionConfiguration): ExtractionStrategyExcel
    {
        return new ExtractionStrategyExcel(
            new SpreadSheetFactory()
        );
    }
}
