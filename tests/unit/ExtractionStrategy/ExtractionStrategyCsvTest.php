<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Tests\unit\ExtractionStrategy;

use Prophecy\Argument\ArgumentsWildcard;
use Prophecy\PhpUnit\ProphecyTrait;
use SplFileObject;
use PHPUnit\Framework\TestCase;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyCsv;
use Xatham\TextExtraction\Tests\helper\UnitTestHelperTrait;

final class ExtractionStrategyCsvTest extends TestCase
{
    use ProphecyTrait, UnitTestHelperTrait;

    /**
     * @test
     */
    public function it_should_parse_csv_content_from_spl_file_object(): void
    {
        $config = $this->getConfigurationDummy();
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
        $targetFileObject->fgetcsv(",", "\"", "\\")->will(function($args, $mock) use ($textData) {
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
