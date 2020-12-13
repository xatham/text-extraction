<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Builder;

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyCsv;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyExcel;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyOpenOfficeDoc;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyPdfSimple;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyPdfWithOCR;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyTextFile;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyWordDoc;
use Xatham\TextExtraction\Extractor\TextExtractor;
use Xatham\TextExtraction\Resolver\MimeTypeResolver;

final class TextExtractionBuilder
{
    public function buildTextExtractor(TextExtractionConfiguration $textExtractionConfiguration): TextExtractor
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

        $fileSystem = new Filesystem(
            new LocalFilesystemAdapter($textExtractionConfiguration->getRootPath())
        );

        // Check what to build and add Factory for injection


        return new TextExtractor($fileSystem, $textExtractionConfiguration, $strategies, new MimeTypeResolver());
    }
}
