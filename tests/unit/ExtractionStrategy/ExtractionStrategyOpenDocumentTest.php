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
use Xatham\TextExtraction\Tests\helper\UnitTestHelperTrait;

class ExtractionStrategyOpenDocumentTest extends TestCase
{
    use ProphecyTrait, UnitTestHelperTrait;

    /**
     * @test
     */
    public function it_should_parse_open_document_content_from_spl_file_object(): void
    {
        $config = $this->getConfigurationDummy();
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
