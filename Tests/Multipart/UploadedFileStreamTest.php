<?php

/*
 * This file is part of the auto1-oss/service-api-components-bundle.
 *
 * (c) AUTO1 Group SE https://www.auto1-group.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Auto1\ServiceAPIComponentsBundle\Tests\Multipart;

use Auto1\ServiceAPIComponentsBundle\Multipart\UploadedFileStream;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadedFileStreamTest extends TestCase
{
    private const TARGET_MIME_TYPE = 'image/png';
    private const TARGET_FILENAME = 'image.png';
    private const TARGET_MODE = 'r';
    private const TARGET_PAYLOAD = 'Test Payload';

    /**
     * @var StreamInterface&MockObject
     */
    private $inner;

    /**
     * @var UploadedFile&MockObject
     */
    private $uploadedFile;

    protected function setUp(): void
    {
        $this->inner = $this->createMock(StreamInterface::class);
        $this->uploadedFile = $this->createMock(UploadedFile::class);
    }

    public function testGetMetadataMimeTypeReturnsClientMimeType(): void
    {
        $this->uploadedFile
            ->method('getClientMimeType')
            ->willReturn(self::TARGET_MIME_TYPE)
        ;

        $this->inner
            ->expects(self::never())
            ->method('getMetadata')
        ;

        $target = $this->getCut();
        $result = $target->getMetadata(UploadedFileStream::METADATA_MIME_TYPE);

        self::assertSame(self::TARGET_MIME_TYPE, $result);
    }

    public function testGetMetadataFilenameReturnsClientOriginalName(): void
    {
        $this->uploadedFile
            ->method('getClientOriginalName')
            ->willReturn(self::TARGET_FILENAME)
        ;

        $this->inner
            ->expects(self::never())
            ->method('getMetadata')
        ;

        $target = $this->getCut();
        $result = $target->getMetadata(UploadedFileStream::METADATA_FILENAME);

        self::assertSame(self::TARGET_FILENAME, $result);
    }

    public function testGetMetadataWithoutKeyMergesInnerWithMimeTypeAndFilename(): void
    {
        $fileMetadata = [
            'wrapper_type' => 'plainfile',
            'mode' => self::TARGET_MODE,
        ];

        $this->inner
            ->method('getMetadata')
            ->with(null)
            ->willReturn($fileMetadata)
        ;

        $this->uploadedFile
            ->method('getClientMimeType')
            ->willReturn(self::TARGET_MIME_TYPE)
        ;

        $this->uploadedFile
            ->method('getClientOriginalName')
            ->willReturn(self::TARGET_FILENAME)
        ;

        $target = $this->getCut();
        $result = $target->getMetadata();

        self::assertSame(
            array_merge(
                $fileMetadata,
                [
                    UploadedFileStream::METADATA_MIME_TYPE => self::TARGET_MIME_TYPE,
                    UploadedFileStream::METADATA_FILENAME => self::TARGET_FILENAME,
                ]
            ),
            $result
        );
    }

    public function testGetMetadataOtherKeyDelegatesToInner(): void
    {
        $this->inner
            ->expects(self::once())
            ->method('getMetadata')
            ->with('mode')
            ->willReturn(self::TARGET_MODE)
        ;

        $target = $this->getCut();
        $result = $target->getMetadata('mode');

        self::assertSame(self::TARGET_MODE, $result);
    }

    public function testReadDelegatesToInner(): void
    {
        $targetLength = 1024;

        $this->inner->expects(self::once())
            ->method('read')
            ->with($targetLength)
            ->willReturn(self::TARGET_PAYLOAD)
        ;

        $target = $this->getCut();
        $result = $target->read($targetLength);

        self::assertSame(self::TARGET_PAYLOAD, $result);
    }

    public function testSeekDelegatesToInner(): void
    {
        $targetOffset = 100;

        $this->inner
            ->expects(self::once())
            ->method('seek')
            ->with($targetOffset, SEEK_SET)
        ;

        $target = $this->getCut();
        $target->seek($targetOffset);
    }

    public function testGetContentsDelegatesToInner(): void
    {
        $this->inner
            ->expects(self::once())
            ->method('getContents')
            ->willReturn(self::TARGET_PAYLOAD)
        ;

        $target = $this->getCut();
        $result = $target->getContents();

        self::assertSame(self::TARGET_PAYLOAD, $result);
    }

    public function testToStringDelegatesToInner(): void
    {
        $targetStringified = 'targetStringified';

        $this->inner
            ->expects(self::once())
            ->method('__toString')
            ->willReturn($targetStringified)
        ;

        $target = $this->getCut();

        self::assertSame($targetStringified, (string) $target);
    }

    public function testCloseDelegatesToInner(): void
    {
        $this->inner
            ->expects(self::once())
            ->method('close')
        ;

        $target = $this->getCut();
        $target->close();
    }

    public function testDetachDelegatesToInner(): void
    {
        $targetResource = fopen('php://memory', 'r');

        $this->inner
            ->expects(self::once())
            ->method('detach')
            ->willReturn($targetResource)
        ;

        $target = $this->getCut();
        $result = $target->detach();

        self::assertSame($targetResource, $result);

        fclose($targetResource);
    }

    public function testGetSizeDelegatesToInner(): void
    {
        $targetSize = 2048;

        $this->inner
            ->expects(self::once())
            ->method('getSize')
            ->willReturn($targetSize)
        ;

        $target = $this->getCut();
        $result = $target->getSize();

        self::assertSame($targetSize, $result);
    }

    public function testTellDelegatesToInner(): void
    {
        $targetPosition = 42;

        $this->inner
            ->expects(self::once())
            ->method('tell')
            ->willReturn($targetPosition)
        ;

        $target = $this->getCut();
        $result = $target->tell();

        self::assertSame($targetPosition, $result);
    }

    public function testEofDelegatesToInner(): void
    {
        $targetEof = true;

        $this->inner
            ->expects(self::once())
            ->method('eof')
            ->willReturn($targetEof)
        ;

        $target = $this->getCut();
        $result = $target->eof();

        self::assertSame($targetEof, $result);
    }

    public function testIsSeekableDelegatesToInner(): void
    {
        $targetIsSeekable = true;

        $this->inner
            ->expects(self::once())
            ->method('isSeekable')
            ->willReturn($targetIsSeekable)
        ;

        $target = $this->getCut();
        $result = $target->isSeekable();

        self::assertSame($targetIsSeekable, $result);
    }

    public function testRewindDelegatesToInner(): void
    {
        $this->inner
            ->expects(self::once())
            ->method('rewind')
        ;

        $target = $this->getCut();
        $target->rewind();
    }

    public function testIsWritableDelegatesToInner(): void
    {
        $targetIsWritable = false;

        $this->inner
            ->expects(self::once())
            ->method('isWritable')
            ->willReturn($targetIsWritable)
        ;

        $target = $this->getCut();
        $result = $target->isWritable();

        self::assertSame($targetIsWritable, $result);
    }

    public function testWriteDelegatesToInner(): void
    {
        $targetBytesWritten = 12;

        $this->inner
            ->expects(self::once())
            ->method('write')
            ->with(self::TARGET_PAYLOAD)
            ->willReturn($targetBytesWritten)
        ;

        $target = $this->getCut();
        $result = $target->write(self::TARGET_PAYLOAD);

        self::assertSame($targetBytesWritten, $result);
    }

    public function testIsReadableDelegatesToInner(): void
    {
        $targetIsReadable = true;

        $this->inner
            ->expects(self::once())
            ->method('isReadable')
            ->willReturn($targetIsReadable)
        ;

        $target = $this->getCut();
        $result = $target->isReadable();

        self::assertSame($targetIsReadable, $result);
    }

    public function testGetUploadedFileReturnsConstructorArgument(): void
    {
        $target = $this->getCut();
        $result = $target->getUploadedFile();

        self::assertSame($this->uploadedFile, $result);
    }

    private function getCut(): UploadedFileStream
    {
        return new UploadedFileStream($this->inner, $this->uploadedFile);
    }
}
