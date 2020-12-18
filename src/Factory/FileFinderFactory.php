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

namespace Xatham\TextExtraction\Factory;

use Symfony\Component\Finder\Finder;

class FileFinderFactory
{
    public function createFinder(): Finder
    {
        return Finder::create();
    }
}
