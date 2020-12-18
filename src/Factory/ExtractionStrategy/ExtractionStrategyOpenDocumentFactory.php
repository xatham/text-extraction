<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Factory\ExtractionStrategy;

use PhpOffice\PhpWord\Reader\ODText;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyOpenDocument;

class ExtractionStrategyOpenDocumentFactory implements ExtractionStrategyFactoryInterface
{
    public function create(TextExtractionConfiguration $textExtractionConfiguration): ExtractionStrategyOpenDocument
    {
        return new ExtractionStrategyOpenDocument(
            new ODText()
        );
    }
}
