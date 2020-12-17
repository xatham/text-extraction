<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Configuration;

class TextExtractionConfiguration
{
    private const OCR_KEY = 'with_ocr';

    private const MIME_TYPE_CSV = 'text/csv';

    private bool $withOCRSupport;

    /**
     * @var string[]
     */
    private array $validMimeTypeCollection = [];

    /**
     * @var array<string, array<string>>
     */
    private array $typeSpecificSettings = [
        self::MIME_TYPE_CSV => [
            'delimiter' => ';',
            'escapeChar' => '"',
            'lineSeparator' => "\n",
        ]
    ];

    /**
     * @param array<string, array<string>> $typeSpecificSettings
     * @param string[] $validMimeTypeCollection
     */
    public function __construct(
        bool $withOCRSupport,
        array $typeSpecificSettings = null,
        array $validMimeTypeCollection = null
    ) {
        $this->withOCRSupport = $withOCRSupport;
        $this->typeSpecificSettings = $typeSpecificSettings ?? $this->typeSpecificSettings;
        $this->validMimeTypeCollection = $validMimeTypeCollection ?? $this->validMimeTypeCollection;
    }

    public function isWithOCRSupport(): bool
    {
        return $this->withOCRSupport;
    }

    /**
     * @return string[]
     */
    public function getValidMimeTypeCollection(): array
    {
        return $this->validMimeTypeCollection;
    }

    /**
     * @return array<string, array<string>>
     */
    public function getTypeSpecificSettings(): array
    {
        return $this->typeSpecificSettings;
    }
}
