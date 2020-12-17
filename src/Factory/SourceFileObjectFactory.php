<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Factory;

use SplFileObject;

class SourceFileObjectFactory
{
    public function getExtractableFileObject(string $filePath): SplFileObject
    {
        return new SplFileObject($filePath, 'rb');
    }
}
