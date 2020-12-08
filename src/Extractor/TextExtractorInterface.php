<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Extractor;

use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\Dto\TextSource;

interface TextExtractorInterface
{
    public function extractByFilePath(string $filePath): ?Document;

    public function extractByString(string $string): ?Document;
}
