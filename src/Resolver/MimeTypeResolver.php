<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Resolver;

use Xatham\TextExtraction\Dto\TextSource;

class MimeTypeResolver
{
    public function getMimeTypeForTextSource(TextSource $textSource): string
    {
        return 'text/csv';
    }
}
