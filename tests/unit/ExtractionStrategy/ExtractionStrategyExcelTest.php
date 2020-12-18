<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Tests\unit\ExtractionStrategy;

use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use SplFileObject;
use Xatham\TextExtraction\Decorator\SimpleXLSXDecorator;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyExcel;
use PHPUnit\Framework\TestCase;
use Xatham\TextExtraction\Tests\helper\UnitTestHelperTrait;

class ExtractionStrategyExcelTest extends TestCase
{
    use ProphecyTrait, UnitTestHelperTrait;

    /**
     * @test
     */
    public function it_should_parse_excel_content_from_spl_file_object(): void
    {
        $config = $this->getConfigurationDummy();

        $targetFileObject = $this->prophesize(SplFileObject::class);
        $targetFileObject->getPath()->willReturn('test')->shouldBeCalledOnce();

        $simpleXLSXMock = $this->prophesize(\SimpleXLSX::class);
        $simpleXLSXMock->rows()->willReturn(['Test string']);

        $excelAdapterMock = $this->prophesize(SimpleXLSXDecorator::class);
        $excelAdapterMock->parse(Argument::any())->willReturn($simpleXLSXMock->reveal())->shouldBeCalledOnce();

        $expectedDocument = new Document();
        $expectedDocument->setTextItems(
            [
                "Test string",
            ]
        );

        $textExtractor = new ExtractionStrategyExcel($excelAdapterMock->reveal());
        self::assertEquals($expectedDocument, $textExtractor->extractSource($targetFileObject->reveal(), $config));
    }
}
