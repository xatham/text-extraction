<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Dto;

class TextItem
{
    private string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
