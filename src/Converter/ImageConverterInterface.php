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

namespace Xatham\TextExtraction\Converter;

use SplFileObject;

interface ImageConverterInterface
{
    /**
     * @return string[]
     */
    public function convertPathTargetToImageFiles(SplFileObject $splFileObject, string $extensionType, ?string $alternatePath): array;
}
