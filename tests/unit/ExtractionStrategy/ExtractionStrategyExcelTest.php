<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Tests\unit\ExtractionStrategy;

use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use SplFileObject;
use Xatham\TextExtraction\Decorator\SimpleXLSXDecorator;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyExcel;
use PHPUnit\Framework\TestCase;

class ExtractionStrategyExcelTest extends TestCase
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
        $targetFileObject->getPath()->willReturn('test')->shouldBeCalledOnce();

        $excelAdapterMock = $this->prophesize(SimpleXLSXDecorator::class);
        $excelAdapterMock->parse(Argument::any())->willReturn('Test string')->shouldBeCalledOnce();

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
