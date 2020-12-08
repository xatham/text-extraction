<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Dto;

class TextSource
{
    private ?string $path = null;

    private ?string $text = null;

    public function __construct(string $path = null, string $text = null)
    {
        $this->path = $path;
        $this->text = $text;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     * @return TextSource
     */
    public function setPath(?string $path): TextSource
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): TextSource
    {
        $this->text = $text;
        return $this;
    }
}
