<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Extractor;

use Xatham\TextExtraction\Dto\Document;

interface TextExtractorInterface
{
    public function extractByFilePath(string $filePath): ?Document;
}
