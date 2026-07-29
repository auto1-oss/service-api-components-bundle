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

use Auto1\ServiceAPIComponentsBundle\Multipart\MetadataStream;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;

class MetadataStreamTest extends TestCase
{
    private const TARGET_FILENAME = 'report.csv';
    private const TARGET_MIME_TYPE = 'text/csv';
    private const TARGET_INNER_METADATA = ['mode' => 'r'];

    /**
     * @var StreamInterface&MockObject
     */
    private $inner;

    protected function setUp(): void
    {
        $this->inner = $this->createMock(StreamInterface::class);
    }

    public function testGetMetadataReturnsGivenFilenameAndMimeType(): void
    {
        $this->inner
            ->expects(self::never())
            ->method('getMetadata')
        ;

        $target = $this->getCut(self::TARGET_FILENAME, self::TARGET_MIME_TYPE);
        $filename = $target->getMetadata(MetadataStream::METADATA_FILENAME);
        $mimeType = $target->getMetadata(MetadataStream::METADATA_MIME_TYPE);

        self::assertSame(self::TARGET_FILENAME, $filename);
        self::assertSame(self::TARGET_MIME_TYPE, $mimeType);
    }

    public function testGetMetadataDelegatesUnsetMetadataKeyToInner(): void
    {
        $this->inner
            ->expects(self::once())
            ->method('getMetadata')
            ->with(MetadataStream::METADATA_FILENAME)
            ->willReturn(null)
        ;

        $target = $this->getCut();
        $result = $target->getMetadata(MetadataStream::METADATA_FILENAME);

        self::assertNull($result);
    }

    public function testGetMetadataWithoutKeyOmitsUnsetEntries(): void
    {
        $this->inner
            ->method('getMetadata')
            ->with(null)
            ->willReturn(self::TARGET_INNER_METADATA)
        ;

        $target = $this->getCut();
        $result = $target->getMetadata();

        self::assertSame(self::TARGET_INNER_METADATA, $result);
    }

    public function testGetMetadataWithoutKeyMergesFilenameAndMimeType(): void
    {
        $expectedMetadata = array_merge(
            self::TARGET_INNER_METADATA,
            [
                MetadataStream::METADATA_MIME_TYPE => self::TARGET_MIME_TYPE,
                MetadataStream::METADATA_FILENAME => self::TARGET_FILENAME,
            ]
        );

        $this->inner
            ->method('getMetadata')
            ->with(null)
            ->willReturn(self::TARGET_INNER_METADATA)
        ;

        $target = $this->getCut(self::TARGET_FILENAME, self::TARGET_MIME_TYPE);
        $result = $target->getMetadata();

        self::assertSame($expectedMetadata, $result);
    }

    private function getCut(?string $filename = null, ?string $mimeType = null): MetadataStream
    {
        return new MetadataStream($this->inner, $filename, $mimeType);
    }
}
