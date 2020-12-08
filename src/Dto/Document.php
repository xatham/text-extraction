<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Dto;

class Document
{
    /**
     * @var string[]
     */
    private array $textItems = [];

    /**
     * @return string[]
     */
    public function getTextItems(): array
    {
        return $this->textItems;
    }

    /**
     * @param string[] $textItems
     */
    public function setTextItems(array $textItems): Document
    {
        $this->textItems = $textItems;

        return $this;
    }
}
