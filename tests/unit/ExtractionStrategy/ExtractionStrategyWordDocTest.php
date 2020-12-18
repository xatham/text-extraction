<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Tests\unit\ExtractionStrategy;

use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Reader\MsDoc;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use SplFileObject;
use Xatham\TextExtraction\Dto\Document;
use PHPUnit\Framework\TestCase;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyWordDoc;
use Xatham\TextExtraction\Tests\helper\UnitTestHelperTrait;

final class ExtractionStrategyWordDocTest extends TestCase
{
    use ProphecyTrait, UnitTestHelperTrait;

    /**
     * @test
     */
    public function it_should_parse_word_doc_content_from_spl_file_object(): void
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

        $odTextMock = $this->prophesize(MsDoc::class);
        $odTextMock->load(Argument::any())->willReturn($phpWordMock);
        $odTextMock->canRead('test')->willReturn(true);

        $textExtractor = new ExtractionStrategyWordDoc($odTextMock->reveal());

        $expectedDocument = new Document();
        $expectedDocument->setTextItems(
            [
                "Test string Another test string.",
            ]
        );
        self::assertEquals($expectedDocument, $textExtractor->extractSource($targetFileObject->reveal(), $config));
    }
}
