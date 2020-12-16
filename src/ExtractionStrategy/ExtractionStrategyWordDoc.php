<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;
use InvalidArgumentException;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Reader\MsDoc;
use SplFileObject;
use Xatham\TextExtraction\Configuration\TextExtractionConfiguration;
use Xatham\TextExtraction\Dto\Document;

class ExtractionStrategyWordDoc implements ExtractionStrategyInterface
{
    private const MIME_TYPE_PDF = 'application/msword';

    /** @var MsDoc */
    private $msDocParser;

    public function __construct(MsDoc $msDocParser)
    {
        $this->msDocParser = $msDocParser;
    }

    public function extractSource(SplFileObject $fileObject, TextExtractionConfiguration $textExtractionConfiguration): ?Document
    {
        $path = $fileObject->getPath();
        if (!$this->msDocParser->canRead($path)) {
            throw new InvalidArgumentException('Could not read ' . $path);
        }
        $docParser = $this->msDocParser->load($path);
        $sections = $docParser->getSections();
        
        if (empty($sections)) {
            return null;
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

        return (new Document())->setTextItems([trim($textString)]);
    }

    public function canHandle(string $mimeType, TextExtractionConfiguration $configuration): bool
    {
        return $mimeType === self::MIME_TYPE_PDF;
    }
}
