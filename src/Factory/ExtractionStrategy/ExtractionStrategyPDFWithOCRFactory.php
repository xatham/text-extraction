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

use Imagick;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Converter\ConvertPdfToImageFileConverter;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyPdfWithOCR;
use Xatham\TextExtraction\Factory\FileFinderFactory;

class ExtractionStrategyPDFWithOCRFactory implements ExtractionStrategyFactoryInterface
{
    public function create(TextExtractionConfiguration $textExtractionConfiguration): ExtractionStrategyPdfWithOCR
    {
        $fileSystemAdapter = new LocalFilesystemAdapter($textExtractionConfiguration->getTempDir());

        return new ExtractionStrategyPdfWithOCR(
            new TesseractOCR(),
            new ConvertPdfToImageFileConverter(
                new Imagick(),
                new FileFinderFactory(),
            ),
            new Filesystem($fileSystemAdapter)
        );
    }
}
