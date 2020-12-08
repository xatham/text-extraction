<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Tests\Unit\ExtractionStrategy;

use Prophecy\PhpUnit\ProphecyTrait;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use PHPUnit\Framework\TestCase;
use Xatham\TextExtraction\Extractor\TextExtractor;
use Xatham\TextExtraction\Resolver\MimeTypeResolver;

final class ExtractionStrategyCsvTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_should_parse_a_string_and_return_null(): void
    {
        $config = new TextExtractionConfiguration(true, ['text/csv']);
        $textExtractor = new TextExtractor($config, [], new MimeTypeResolver());
        self::assertEquals(null, $textExtractor->extractByString('test'));
    }
}
