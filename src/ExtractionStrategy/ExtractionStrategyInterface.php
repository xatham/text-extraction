<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;

use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\Dto\TextSource;

interface ExtractionStrategyInterface
{
    public function extractSource(TextSource $textSource): ?Document;

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool;
}
