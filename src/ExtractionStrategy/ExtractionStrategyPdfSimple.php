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

namespace Xatham\TextExtraction\ExtractionStrategy;

use Smalot\PdfParser\Parser;
use SplFileObject;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;

class ExtractionStrategyPdfSimple implements ExtractionStrategyInterface
{
    private const MIME_TYPE_PDF = 'application/pdf';

    private Parser $pdfParser;

    public function __construct(Parser $pdfParser)
    {
        $this->pdfParser = $pdfParser;
    }

    public function extractSource(SplFileObject $fileObject, TextExtractionConfiguration $textExtractionConfiguration): ?Document
    {
        $content = '';
        while ($fileObject->eof() === false) {
            $content .= $fileObject->fgets();
        }
        $parsedDocument = $this->pdfParser->parseContent($content);

        return (new Document())->setTextItems([$parsedDocument->getText()]);
    }

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool
    {
        return
            $mimeType === self::MIME_TYPE_PDF &&
            $configuration->isWithOCRSupport() === false;
    }
}
