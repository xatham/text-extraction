<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Tests\unit\ExtractionStrategy;

use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Smalot\PdfParser\Parser;
use SplFileObject;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyPdfSimple;
use PHPUnit\Framework\TestCase;

final class ExtractionStrategyPdfSimpleTest extends TestCase
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
        $targetFileObject->fgets()->willReturn('Test string Another test string.')->shouldBeCalledOnce();

        $parseDocument = $this->prophesize(\Smalot\PdfParser\Document::class);
        $parseDocument->getText()->willReturn('Test string Another test string.');

        $pdfMock = $this->prophesize(Parser::class);
        $pdfMock->parseContent(Argument::any())->willReturn($parseDocument);

        $expectedDocument = new Document();
        $expectedDocument->setTextItems(
            [
                "Test string Another test string.",
            ]
        );

        $textExtractor = new ExtractionStrategyPdfSimple($pdfMock->reveal());
        self::assertEquals($expectedDocument, $textExtractor->extractSource($targetFileObject->reveal(), $config));

    }
}
