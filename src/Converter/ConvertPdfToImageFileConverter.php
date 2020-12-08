<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Converter;

use Imagick;
use Symfony\Component\Finder\Finder;

class ConvertPdfToImageFileConverter implements ImageConverterInterface
{
    private const MULTI_FILE_NAME_SUFFIX = '__gen';

    public function convertToImageFiles(string $filePath, string $extensionType, ?string $alternatePath = null): array
    {
        $targetPath = $alternatePath ?? preg_replace('/\.pdf$/', '.' . $extensionType, $filePath);
        $imagick    = new Imagick();
        $imagick->setResolution(300, 300);
        $imagick->readImage($filePath);
        $imagick->resetIterator();

        $fileObject = new \SplFileObject($filePath);
        $baseNameWithoutExtension = $fileObject->getBasename('.pdf');

        $adjoin = $imagick->count() < 400;
        $multiFileNameStamp = $baseNameWithoutExtension . $this->getGeneratedMultiFileStamp() . '.'. $extensionType->getValue();
        $tempTargetPath     = $fileObject->getPath() . DIRECTORY_SEPARATOR . $multiFileNameStamp;

        $imagick->setImageFormat($extensionType->getValue());
        $imagick->appendImages(false);
        $imagick->writeImages($tempTargetPath, false);
        $imagick->clear();
        $imagick->destroy();

        $finder = new Finder();
        $finder
            ->files()
            ->in($fileObject->getPath())
            ->name('*' . $this->getGeneratedMultiFileStamp() . '*')
            ->sortByName(true);

        $fileNames = [];
        foreach ($finder as $file) {
            $fileNames[] = $file->getRealPath();
        }

        return $fileNames;
    }

    private function getGeneratedMultiFileStamp(): string
    {
        return (new \DateTimeImmutable())->getTimestamp() . self::MULTI_FILE_NAME_SUFFIX;
    }
}
