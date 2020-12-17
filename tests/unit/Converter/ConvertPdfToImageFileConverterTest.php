<?php

declare(strict_types=1);

namespace Xatham\TextExtraction\Tests\unit\Converter;

use Imagick;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use SplFileInfo;
use SplFileObject;
use Symfony\Component\Finder\Finder;
use Xatham\TextExtraction\Converter\ConvertPdfToImageFileConverter;
use Xatham\TextExtraction\Factory\FileFinderFactory;

final class ConvertPdfToImageFileConverterTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_should_correctly_convert_path_into_images(): void
    {
        $targetFileObject = $this->prophesize(SplFileObject::class);
        $targetFileObject->getPath()->willReturn('test')->shouldBeCalledOnce();
        $targetFileObject->getRealPath()->willReturn('test')->shouldBeCalledOnce();
        $targetFileObject->getbaseName('.pdf')->willReturn('test')->shouldBeCalledOnce();

        $imagickMock = $this->prophesize(Imagick::class);
        $imagickMock->setResolution(300, 300)->shouldBeCalledOnce();
        $imagickMock->readImage(Argument::any())->shouldBeCalledOnce();
        $imagickMock->resetIterator()->shouldBeCalledOnce();
        $imagickMock->setImageFormat(Argument::any())->shouldBeCalledOnce();
        $imagickMock->appendImages(Argument::any())->shouldBeCalledOnce();
        $imagickMock->writeImages(Argument::any(), Argument::any())->shouldBeCalledOnce();
        $imagickMock->clear()->shouldBeCalledOnce();
        $imagickMock->destroy()->shouldBeCalledOnce();

        $iteratorMock = $this->prophesize(Finder::class);
        $iteratorMock->getIterator()->willReturn(new \ArrayIterator(['test.jpg']));

        $splInfoMock1 = $this->prophesize(SplFileInfo::class);
        $splInfoMock1->getRealpath()->willReturn('testfile1.jpg');

        $splInfoMock2 = $this->prophesize(SplFileInfo::class);
        $splInfoMock2->getRealpath()->willReturn('testfile2.jpg');

        $finderFactoryMock = $this->prophesize(FileFinderFactory::class);
        $finderFactoryMock->createFinder()->willReturn($this->getSymfonyFinderMock());

        $converter = new ConvertPdfToImageFileConverter($imagickMock->reveal(), $finderFactoryMock->reveal());
        $imageFileNames = $converter->convertPathTargetToImageFiles($targetFileObject->reveal(), 'pdf');

        $expectedNames = [
            'testfile1.jpg',
            'testfile2.jpg',
        ];
        self::assertEquals($expectedNames, $imageFileNames);
    }

    private function getSymfonyFinderMock(): Finder
    {
        $splInfoMock1 = $this->prophesize(SplFileInfo::class);
        $splInfoMock1->getRealpath()->willReturn('testfile1.jpg');

        $splInfoMock2 = $this->prophesize(SplFileInfo::class);
        $splInfoMock2->getRealpath()->willReturn('testfile2.jpg');

        return new class([$splInfoMock1->reveal(), $splInfoMock2->reveal()]) extends Finder {

            private array $mock = [];

            public function __construct($data)
            {
                $this->mock = $data;
            }

            public function getIterator()
            {
                return new \ArrayIterator(
                    $this->mock,
                );
            }

            public function files(): Finder
            {
                return $this;
            }

            public function in($dirs)
            {
                return $this;
            }

            public function name($patterns)
            {
                return $this;
            }

            public function sortByName(bool $useNaturalSort = false)
            {
                return $this;
            }
        };
    }
}
