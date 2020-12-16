<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Tests\unit\ExtractionStrategy;

use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Reader\ODText;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use SplFileObject;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyOpenDocument;
use PHPUnit\Framework\TestCase;

class ExtractionStrategyOpenDocumentTest extends TestCase
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

        $section = new Section(0);
        $section->addText('Test string');
        $section->addText('Another test string.');
        $sections = [
            $section,
        ];

        $phpWordMock = $this->prophesize(PhpWord::class);
        $phpWordMock->getSections()->willReturn($sections);

        $odTextMock = $this->prophesize(ODText::class);
        $odTextMock->load(Argument::any())->willReturn($phpWordMock);
        $odTextMock->canRead('test')->willReturn(true);

        $textExtractor = new ExtractionStrategyOpenDocument($odTextMock->reveal());

        $expectedDocument = new Document();
        $expectedDocument->setTextItems(
            [
                "Test string Another test string.",
            ]
        );
        self::assertEquals($expectedDocument, $textExtractor->extractSource($targetFileObject->reveal(), $config));
    }
}
