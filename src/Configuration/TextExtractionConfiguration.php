<?php

/**
 * This file is part of the Xatham/text-extraction package.
 *
 * (c) Xatham <s.kirejewski@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Xatham\TextExtraction\Configuration;

class TextExtractionConfiguration
{
    private const MIME_TYPE_CSV = 'text/csv';

    private bool $withOCRSupport;

    private bool $pagination;

    /**
     * @var string[]
     */
    private array $validMimeTypeCollection = [];

    /**
     * @var array<string, array<string>>
     */
    private array $typeSpecificSettings = [
        self::MIME_TYPE_CSV => [
            'delimiter' => ',',
            'enclosure' => '"',
            'escape' => '\\',
        ],
    ];

    private string $tempDir;

    /**
     * @param array<string, array<string>> $typeSpecificSettings
     * @param string[] $validMimeTypeCollection
     */
    public function __construct(
        bool $withOCRSupport,
        bool $pagination,
        string $tempDir,
        array $typeSpecificSettings,
        array $validMimeTypeCollection
    ) {
        $this->withOCRSupport = $withOCRSupport;
        $this->pagination = $pagination;
        $this->tempDir = $tempDir;
        $this->typeSpecificSettings = array_merge($this->typeSpecificSettings, $typeSpecificSettings);
        $this->validMimeTypeCollection = array_merge($this->validMimeTypeCollection, $validMimeTypeCollection);
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

    public function getTempDir(): string
    {
        return $this->tempDir;
    }

    /**
     * @return bool
     */
    public function withPagination(): bool
    {
        return $this->pagination;
    }
}
