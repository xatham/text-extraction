<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;

use InvalidArgumentException;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Reader\ODText;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\Dto\TextSource;

class ExtractionStrategyOpenOfficeDoc implements ExtractionStrategyInterface
{
    private const MIME_TYPE = 'application/vnd.oasis.opendocument.text';

    /** @var ODText */
    private $docParser;

    public function __construct(PhpWord $wordDocParser)
    {
        $this->docParser = $wordDocParser;
    }

    public function extractSource(SplFileObject $fileObject, TextExtractionConfiguration $textExtractionConfiguration): ?Document
    {
        if (!$this->docParser->canRead($fileObject->getPath())) {
            throw new InvalidArgumentException('Could not read');
        }

        $docParser = $this->docParser->load($fileObject->getPath());
        $sections = $docParser->getSections();
        $document =  new Document();

        if (empty($sections)) {
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
        $document->setTextItems([$textString]);

        return $document;
    }

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool
    {
        return $mimeType === self::MIME_TYPE;
    }
}
