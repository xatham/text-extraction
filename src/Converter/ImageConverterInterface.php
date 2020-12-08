<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Converter;

interface ImageConverterInterface
{
    public function convertToImageFiles(string $filePath, string $extensionType, ?string $alternatePath): array;
}
