<?php

/**
 * This file is part of the Xatham/text-extraction package.
 *
 * (c) Xatham <s.kirejewski@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

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
