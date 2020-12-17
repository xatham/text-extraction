<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Decorator;

use SimpleXLSX;

class SimpleXLSXDecorator
{
    private SimpleXLSX $simpleXlsx;

    public function __construct(SimpleXLSX $simpleXlsx)
    {
        $this->simpleXlsx = $simpleXlsx;
    }

    /**
     * @return bool|SimpleXLSX
     */
    public function parse(string $path)
    {
        return SimpleXLSX::parse($path);
    }
}
