<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Converter;

use SplFileObject;

interface ImageConverterInterface
{
    /**
     * @return string[]
     */
    public function convertPathTargetToImageFiles(SplFileObject $splFileObject, string $extensionType, ?string $alternatePath): array;
}
