<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Tests\unit\Extractor;

use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use SplFileObject;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\ExtractionStrategy\ExtractionStrategyInterface;
use Xatham\TextExtraction\Extractor\TextExtractor;
use PHPUnit\Framework\TestCase;
use Xatham\TextExtraction\Factory\SourceFileObjectFactory;
use Xatham\TextExtraction\Resolver\MimeTypeResolver;
use Xatham\TextExtraction\Tests\helper\UnitTestHelperTrait;

final class TextExtractorTest extends TestCase
{
    use ProphecyTrait, UnitTestHelperTrait;

    /**
     * @test
     */
    public function it_should_handle_path_by_passing_it_to_strategy(): void
    {
        $config = $this->getConfigurationDummy();
        $extractionMock = $this->prophesize(ExtractionStrategyInterface::class);

        $expectedDocument = new Document();
        $expectedDocument->setTextItems(
            [
                "Test string Another test string.",
            ]
        );

        $targetFileObject = $this->prophesize(SplFileObject::class);

        $extractionMock->canHandle(Argument::any(), $config)->willReturn(true);
        $extractionMock->extractSource(Argument::any(), $config)->willReturn($expectedDocument);

        $mimeTypeResolverMock = $this->prophesize(MimeTypeResolver::class);
        $mimeTypeResolverMock->getMimeTypeForTextSource($targetFileObject->reveal())->willReturn('text/plain');

        $sourceFileObjectFactoryMock = $this->prophesize(SourceFileObjectFactory::class);
        $sourceFileObjectFactoryMock->getExtractableFileObject(Argument::any())->willReturn($targetFileObject);

        $textExtractor = new TextExtractor(
            $config,
            $mimeTypeResolverMock->reveal(),
            $sourceFileObjectFactoryMock->reveal(),
            $extractionMock->reveal()
        );

        self::assertEquals($expectedDocument, $textExtractor->extractByFilePath('/tmp/test'));
    }
}
