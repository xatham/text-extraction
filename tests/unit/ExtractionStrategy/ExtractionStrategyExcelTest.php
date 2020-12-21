<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Tests\unit\ExtractionStrategy;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use SplFileObject;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyExcel;
use PHPUnit\Framework\TestCase;
use Xatham\TextExtraction\Factory\SpreadSheetFactory;
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
        $targetFileObject->getRealPath()->willReturn('test')->shouldBeCalledOnce();

        $workSheetMock = $this->prophesize(Worksheet::class);
        $workSheetMock->toArray()->willReturn(
            [
                ['Test', 'string'],
            ],
        );
        $workSheetArrayMock = [
            $workSheetMock->reveal(),
        ];
        $spreadSheetMock = $this->prophesize(Spreadsheet::class);
        $spreadSheetMock->getAllSheets()->willReturn($workSheetArrayMock);

        $spreadSheetFactoryMock = $this->prophesize(SpreadSheetFactory::class);
        $spreadSheetFactoryMock->createSpreadSheet(Argument::any())->willReturn($spreadSheetMock->reveal())->shouldBeCalledOnce();

        $expectedDocument = new Document();
        $expectedDocument->setTextItems(
            [
                "Test, string",
            ]
        );

        $textExtractor = new ExtractionStrategyExcel($spreadSheetFactoryMock->reveal());
        self::assertEquals($expectedDocument, $textExtractor->extractSource($targetFileObject->reveal(), $config));
    }
}
