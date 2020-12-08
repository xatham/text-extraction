<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\ExtractionStrategy;
use App\BusinessLogic\Document\Parser\ParsingContext;
use App\BusinessLogic\Document\Parser\Strategy\ExtractionStrategyInterface;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Reader\MsDoc;
use Xatham\TextExtraction\Dto\Document;
use Xatham\TextExtraction\Dto\TextSource;

class ExtractionStrategyWordDoc implements ExtractionStrategyInterface
{
    private const MIME_TYPE_PDF = 'application/msword';

    /** @var MsDoc */
    private $wordDocParser;

    public function __construct(PhpWord $wordDocParser)
    {
        $this->wordDocParser = $wordDocParser;
    }

    public function extractDocument(TextSource $textSource): Document
    {
        if (!$this->wordDocParser->canRead($textSource->getPath())) {
            throw new \InvalidArgumentException('Could not read');
        }

        $docParser = $this->wordDocParser->load($textSource->getPath());
        $sections = $docParser->getSections();

        if (empty($sections)) {
            return $parsableModel;
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
        $parsableModel->setPlainTexts([$textString]);

        return $parsableModel;
    }

    public function canHandle(ParsingContext $context): bool
    {
        return $context->getMimeType() === self::MIME_TYPE_PDF;
    }
}
