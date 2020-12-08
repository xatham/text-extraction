<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Dto;

class Document
{
    /**
     * @var TextItem[]
     */
    private array $textItems = [];

    /**
     * @return TextItem[]
     */
    public function getTextItems(): array
    {
        return $this->textItems;
    }

    /**
     * @param TextItem[] $textItems
     */
    public function setTextItems(array $textItems): Document
    {
        $this->textItems = $textItems;

        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }
}
