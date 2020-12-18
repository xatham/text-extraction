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

namespace Xatham\TextExtraction\Converter;

use DateTimeImmutable;
use Imagick;
use ImagickException;
use RuntimeException;
use SplFileObject;
use Xatham\TextExtraction\Factory\FileFinderFactory;

class ConvertPdfToImageFileConverter implements ImageConverterInterface
{
    private const MULTI_FILE_NAME_SUFFIX = '__gen';

    private Imagick $imageDriver;

    private FileFinderFactory $fileFinderFactory;

    public function __construct(Imagick $imageDriver, FileFinderFactory $fileFinderFactory)
    {
        $this->imageDriver = $imageDriver;
        $this->fileFinderFactory = $fileFinderFactory;
    }

    /**
     * @return string[]
     *
     * @throws ImagickException
     */
    public function convertPathTargetToImageFiles(SplFileObject $splFileObject, string $extensionType, ?string $alternatePath = null): array
    {
        $path = $alternatePath ?? $splFileObject->getPath();
        $realPath = $splFileObject->getRealPath();
        if ($realPath === false) {
            throw new RuntimeException('Unable to retrieve path for current file object');
        }
        $this->imageDriver->setResolution(300, 300);
        $this->imageDriver->readImage($realPath);
        $this->imageDriver->resetIterator();

        $baseNameWithoutExtension = $splFileObject->getBasename('.pdf');
        // $adjoin = $this->imageDriver->count() < 400;
        $multiFileNameStamp = $baseNameWithoutExtension . $this->getGeneratedMultiFileStamp() . '.' . $extensionType;
        $tempTargetPath = $path . DIRECTORY_SEPARATOR . $multiFileNameStamp;

        $this->imageDriver->setImageFormat($extensionType);
        $this->imageDriver->appendImages(false);
        $this->imageDriver->writeImages($tempTargetPath, false);
        $this->imageDriver->clear();
        $this->imageDriver->destroy();

        $finder = $this->fileFinderFactory->createFinder();
        $finder
            ->files()
            ->ignoreUnreadableDirs()
            ->in($path)
            ->name('*' . $this->getGeneratedMultiFileStamp() . '*')
            ->sortByName(true);

        $fileNames = [];
        foreach ($finder as $file) {
            $realPath = $file->getRealPath();
            if ($realPath === false) {
                throw new RuntimeException('Unable to retrieve path for newly created image file. Check folder permissions');
            }
            $fileNames[] = $realPath;
        }

        return $fileNames;
    }

    private function getGeneratedMultiFileStamp(): string
    {
        return (new DateTimeImmutable())->getTimestamp() . self::MULTI_FILE_NAME_SUFFIX;
    }
}
