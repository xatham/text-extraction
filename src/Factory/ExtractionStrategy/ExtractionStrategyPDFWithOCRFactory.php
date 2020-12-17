<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Factory\ExtractionStrategy;

use Imagick;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Xatham\TextExtraction\Converter\ConvertPdfToImageFileConverter;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyPdfWithOCR;
use Xatham\TextExtraction\Factory\FileFinderFactory;

class ExtractionStrategyPDFWithOCRFactory implements ExtractionStrategyFactoryInterface
{
    public function create(): ExtractionStrategyPdfWithOCR
    {
        return new ExtractionStrategyPdfWithOCR(
            new TesseractOCR(),
            new ConvertPdfToImageFileConverter(
                new Imagick(),
                new FileFinderFactory()
            )
        );
    }
}
