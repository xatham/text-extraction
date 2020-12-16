<?php

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
