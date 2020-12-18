<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Factory\ExtractionStrategy;

use PhpOffice\PhpWord\Reader\MsDoc;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyWordDoc;

class ExtractionStrategyWordDocFactory implements ExtractionStrategyFactoryInterface
{
    public function create(TextExtractionConfiguration $textExtractionConfiguration): ExtractionStrategyWordDoc
    {
        return new ExtractionStrategyWordDoc(
            new MsDoc()
        );
    }
}
