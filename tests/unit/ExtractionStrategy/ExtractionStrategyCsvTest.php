<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Tests\unit\ExtractionStrategy;

use Prophecy\Argument\ArgumentsWildcard;
use Prophecy\PhpUnit\ProphecyTrait;
use SplFileObject;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use PHPUnit\Framework\TestCase;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyCsv;

final class ExtractionStrategyCsvTest extends TestCase
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
        $targetFileObject->rewind()->shouldBeCalledOnce();
        $targetFileObject->eof()->will(function($args, $mock) {
            $methodCalls = $mock->findProphecyMethodCalls(
                'eof',
                new ArgumentsWildcard($args)
            );
            return count($methodCalls) < 2 ? false : true;
        })->shouldBeCalled();

        $textData = [
            ["This", "is" , "a", "text"],
            ["A", "second" , "test", "."],
        ];
        $targetFileObject->fgetcsv()->will(function($args, $mock) use ($textData) {
            $methodCalls = $mock->findProphecyMethodCalls(
                'fgetcsv',
                new ArgumentsWildcard($args)
            );
            return count($methodCalls) < 2 ? $textData[count($methodCalls)] : false;
        });

        $textExtractor = new ExtractionStrategyCsv();
        $expectedDocument = new Document();
        $expectedDocument->setTextItems(
            [
                "This is a textA second test .",
            ]
        );
        self::assertEquals($expectedDocument, $textExtractor->extractSource($targetFileObject->reveal(), $config));
    }
}
