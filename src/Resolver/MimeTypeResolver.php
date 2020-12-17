<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Resolver;

use finfo;
use SplFileObject;

class MimeTypeResolver
{
    public function getMimeTypeForTextSource(SplFileObject $splFileObject): string
    {
        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        return $fileInfo->file($splFileObject->getRealPath());
    }
}
