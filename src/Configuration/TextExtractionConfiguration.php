<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Configuration;

class TextExtractionConfiguration
{
    private bool $withOCRSupport;

    private array $validMimeTypeCollection = [];

    public function __construct(bool $withOCRSupport, array $validMimeTypeCollection)
    {
        $this->withOCRSupport = $withOCRSupport;
        $this->validMimeTypeCollection = $validMimeTypeCollection;
    }

    public function isWithOCRSupport(): bool
    {
        return $this->withOCRSupport;
    }

    public function getValidMimeTypeCollection(): array
    {
        return $this->validMimeTypeCollection;
    }
}
