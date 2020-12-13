<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Adapter;

use SimpleXLSX;

class SimpleXLSCAdapter
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
