<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Builder;

use SplFileObject;

final class SourceFileObjectBuilder
{
    public function getExtractableFileObject(string $filePath): SplFileObject
    {
        return new SplFileObject($filePath);
    }
}
