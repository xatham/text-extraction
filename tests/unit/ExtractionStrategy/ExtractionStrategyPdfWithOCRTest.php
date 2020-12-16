<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Tests\unit\ExtractionStrategy;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use SplFileObject;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Converter\ConvertPdfToImageFileConverter;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyPdfWithOCR;

class ExtractionStrategyPdfWithOCRTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_should_parse_a_string_and_return_null(): void
    {
        $config = new TextExtractionConfiguration(
            '/tmp',
            true,
            ['text/csv'],
        );

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
        $converterMock->convertPathTargetToImageFiles(Argument::any(), 'jpg')->willReturn(
            [
                'image1.jpg',
                'image2.jpg',
            ]
        );

        $textExtractor = new ExtractionStrategyPdfWithOCR(
            $tesseractMock->reveal(),
            $converterMock->reveal()
        );

        self::assertEquals($expectedDocument, $textExtractor->extractSource(
            $targetFileObject->reveal(),
            $config
        )
        );
    }
}
