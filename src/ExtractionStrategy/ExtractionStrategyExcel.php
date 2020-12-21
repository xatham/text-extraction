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

namespace Xatham\TextExtraction\ExtractionStrategy;

use SplFileObject;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\Factory\SpreadSheetFactory;

class ExtractionStrategyExcel implements ExtractionStrategyInterface
{
    private const MIME_TYPE_EXCEL = 'application/vnd.ms-excel';

    private SpreadSheetFactory $spreadSheetFactory;

    public function __construct(SpreadSheetFactory $spreadSheetFactory)
    {
        $this->spreadSheetFactory = $spreadSheetFactory;
    }

    public function extractSource(SplFileObject $fileObject, TextExtractionConfiguration $textExtractionConfiguration): ?Document
    {
        /** @var string $realPath */
        $realPath = $fileObject->getRealPath();
        $spreadSheet = $this->spreadSheetFactory->createSpreadSheet($realPath);
        $document = new Document();
        $workSheets = $spreadSheet->getAllSheets();
        $contents = '';

        foreach ($workSheets as $workSheet) {
            $worksheetData = $workSheet->toArray();
            foreach ($worksheetData as $key => $value) {
                $contents .= implode(', ', array_filter($value));
            }
        }
        $document->setTextItems([$contents]);

        return $document;
    }

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool
    {
        return $mimeType === self::MIME_TYPE_EXCEL;
    }
}
