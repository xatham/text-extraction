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
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyTextFile;

class ExtractionStrategyTextFileFactory implements ExtractionStrategyFactoryInterface
{
    public function create(TextExtractionConfiguration $textExtractionConfiguration): ExtractionStrategyTextFile
    {
        return new ExtractionStrategyTextFile();
    }
}
