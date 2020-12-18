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

namespace Xatham\TextExtraction\Resolver;

use finfo;
use RuntimeException;
use SplFileObject;

class MimeTypeResolver
{
    public function getMimeTypeForTextSource(SplFileObject $splFileObject): string
    {
        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $path = $splFileObject->getRealPath();
        if ($path === false) {
            throw new RuntimeException(sprintf('Unable to retrieve real path for given file object'));
        }
        $mimeType = $fileInfo->file($path);
        if ($mimeType === false) {
            throw new RuntimeException(sprintf('Unable to determine mime type for file %s', $path));
        }

        return $mimeType;
    }
}
