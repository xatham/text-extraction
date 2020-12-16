<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Decorator;

use SimpleXLSX;

class SimpleXLSCDecorator
{
    private SimpleXLSX $simpleXlsx;

    public function __construct(SimpleXLSX $simpleXlsx)
    {
        $this->simpleXlsx = $simpleXlsx;
    }

    public function parse(string $path)
    {
        return SimpleXLSX::parse($path);
    }
}
