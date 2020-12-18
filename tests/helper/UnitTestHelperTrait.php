<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Tests\helper;

use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;

trait UnitTestHelperTrait
{
    private function getConfigurationDummy(): TextExtractionConfiguration
    {
        return new TextExtractionConfiguration(
            true,
            '/tmp',
            [],
        );
    }
}
