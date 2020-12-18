<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Tests\unit\ExtractionStrategy;

use League\Flysystem\Filesystem;
use PhpParser\Node\Arg;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use SplFileObject;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Converter\ConvertPdfToImageFileConverter;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyPdfWithOCR;
use Xatham\TextExtraction\Tests\helper\UnitTestHelperTrait;

class ExtractionStrategyPdfWithOCRTest extends TestCase
{
    use ProphecyTrait, UnitTestHelperTrait;

    /**
     * @test
     */
    public function it_should_parse_pdf_with_ocr_content_from_spl_file_object(): void
    {
        $config = $this->getConfigurationDummy();

        $targetFileObject = $this->prophesize(SplFileObject::class);

        $expectedDocument = new Document();
        $expectedDocument->setTextItems(
            [<<<TEXT
                Test string Another test string.
                Test string Another test string.
                TEXT
            ]
        );
        $tesseractImageMock = $this->prophesize(TesseractOCR::class);
        $tesseractImageMock->run()->willReturn(
            "Test string Another test string."
        );

        $tesseractMock = $this->prophesize(TesseractOCR::class);
        $tesseractMock->image(Argument::any())->willReturn($tesseractImageMock->reveal());

        $converterMock = $this->prophesize(ConvertPdfToImageFileConverter::class);
        $converterMock->convertPathTargetToImageFiles(Argument::any(), 'jpg', Argument::any())->willReturn(
            [
                'image1.jpg',
                'image2.jpg',
            ]
        );
        $fileSystemMock = $this->prophesize(Filesystem::class);
        $fileSystemMock->delete(Argument::any());

        $textExtractor = new ExtractionStrategyPdfWithOCR(
            $tesseractMock->reveal(),
            $converterMock->reveal(),
            $fileSystemMock->reveal()
        );

        self::assertEquals($expectedDocument, $textExtractor->extractSource(
            $targetFileObject->reveal(),
            $config
        )
        );
    }
}
