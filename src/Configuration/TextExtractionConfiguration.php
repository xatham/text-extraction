<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Configuration;

class TextExtractionConfiguration
{
    private const MIME_TYPE_CSV = 'text/csv';
    private const MIME_TYPE_PLAIN = 'text/plain';
    private const MIME_TYPE_EXCEL = 'application/vnd.ms-excel';
    private const MIME_TYPE_OPEN_DOCUMENT_TEXT = 'application/vnd.oasis.opendocument.text';

    private bool $withOCRSupport;

    /**
     * @var string[]
     */
    private array $validMimeTypeCollection = [];

    private string $rootPath;

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
        string $rootPath,
        bool $withOCRSupport,
        array $typeSpecificSettings = null,
        array $validMimeTypeCollection = null
    ) {
        $this->rootPath = $rootPath;
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

    public function getRootPath(): string
    {
        return $this->rootPath;
    }
}
