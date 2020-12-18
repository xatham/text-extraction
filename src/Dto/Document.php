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
