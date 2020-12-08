<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Builder;

use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyCsv;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyExcel;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyOpenOfficeDoc;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyPdfSimple;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyPdfWithOCR;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyTextFile;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyWordDoc;
use Xatham\TextExtraction\Resolver\MimeTypeResolver;
use Xatham\TextExtraction\TextExtractor;
use Xatham\TextExtraction\TextExtractorInterface;

class TextExtractionBuilder
{
    public function buildTextExtractor(TextExtractionConfiguration $textExtractionConfiguration): TextExtractorInterface
    {
        $strategies = [
            ExtractionStrategyCsv::class,
            ExtractionStrategyExcel::class,
            ExtractionStrategyOpenOfficeDoc::class,
            ExtractionStrategyPdfWithOCR::class,
            ExtractionStrategyPdfSimple::class,
            ExtractionStrategyTextFile::class,
            ExtractionStrategyWordDoc::class,
        ];
        return new TextExtractor($textExtractionConfiguration, $strategies, new MimeTypeResolver());
    }
}
