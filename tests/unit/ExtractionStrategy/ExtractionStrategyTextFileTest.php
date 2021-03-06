<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Tests\unit\ExtractionStrategy;

use Prophecy\Argument\ArgumentsWildcard;
use Prophecy\PhpUnit\ProphecyTrait;
use SplFileObject;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyTextFile;
use PHPUnit\Framework\TestCase;
use Xatham\TextExtraction\Tests\helper\UnitTestHelperTrait;

final class ExtractionStrategyTextFileTest extends TestCase
{
    use ProphecyTrait, UnitTestHelperTrait;

    /**
     * @test
     */
    public function it_should_parse_textfile_content_from_spl_file_object(): void
    {
        $config = $this->getConfigurationDummy();
        $targetFileObject = $this->prophesize(SplFileObject::class);
        $targetFileObject->eof()->will(function($args, $mock) {
            $methodCalls = $mock->findProphecyMethodCalls(
                'eof',
                new ArgumentsWildcard($args)
            );
            return count($methodCalls) < 1 ? false : true;
        })->shouldBeCalled();

        $textData = [
            "Test string Another test string.",
        ];
        $targetFileObject->fgets()->will(function($args, $mock) use ($textData) {
            $methodCalls = $mock->findProphecyMethodCalls(
                'fgetcsv',
                new ArgumentsWildcard($args)
            );
            return count($methodCalls) < 1 ? $textData[count($methodCalls)] : false;
        });

        $expectedDocument = new Document();
        $expectedDocument->setTextItems(
            [
                "Test string Another test string.",
            ]
        );

        $textExtractor = new ExtractionStrategyTextFile();
        self::assertEquals($expectedDocument, $textExtractor->extractSource($targetFileObject->reveal(), $config));
    }
}
