<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Tests\unit\Extractor;

use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\Dto\TextItem;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyInterface;
use Xatham\TextExtraction\Extractor\TextExtractor;
use PHPUnit\Framework\TestCase;
use Xatham\TextExtraction\Resolver\MimeTypeResolver;

final class TextExtractorTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_should_parse_a_string_and_return_null(): void
    {
        $config = new TextExtractionConfiguration(
            true,
            true,
            ['text/csv']
        );
        $textExtractor = new TextExtractor($config, [], new MimeTypeResolver());
        self::assertEquals(null, $textExtractor->extractByString('test'));
    }

    /**
     * @test
     */
    public function given_a_string_it_should_parse_it_and_return_the_parsed_test_string(): void
    {
        $expected = (new Document())->setTextItems([new TextItem('test')]);

        $config = new TextExtractionConfiguration(true, ['text/csv']);
        $strategyMock = $this->prophesize(ExtractionStrategyInterface::class);
        $strategyMock->canHandle(Argument::any(), $config)->willReturn(true);
        $strategyMock->extractSource(Argument::any())->willReturn($expected);

        $strategies = [
            $strategyMock->reveal()
        ];
        $textExtractor = new TextExtractor($config, $strategies, new MimeTypeResolver());

        self::assertEquals($expected, $textExtractor->extractByString('test'));
    }
}
