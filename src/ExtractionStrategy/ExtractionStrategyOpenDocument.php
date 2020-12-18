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

use InvalidArgumentException;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Reader\ODText;
use SplFileObject;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;

class ExtractionStrategyOpenDocument implements ExtractionStrategyInterface
{
    private const MIME_TYPE = 'application/vnd.oasis.opendocument.text';

    /** @var ODText */
    private $docParser;

    public function __construct(ODText $openDocParser)
    {
        $this->docParser = $openDocParser;
    }

    public function extractSource(SplFileObject $fileObject, TextExtractionConfiguration $textExtractionConfiguration): ?Document
    {
        $filePath = $fileObject->getPath();
        if (!$this->docParser->canRead($filePath)) {
            throw new InvalidArgumentException('Could not read ' . $filePath);
        }

        $docParser = $this->docParser->load($filePath);
        $sections = $docParser->getSections();
        $document = new Document();

        if (count($sections) === 0) {
            return $document;
        }
        $textString = '';
        foreach ($sections as $section) {
            $elements = $section->getElements();
            foreach ($elements as $element) {
                if ($element instanceof Text) {
                    $textString .= ' ' . $element->getText();
                }
            }
        }
        $document->setTextItems([trim($textString)]);

        return $document;
    }

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool
    {
        return $mimeType === self::MIME_TYPE;
    }
}
