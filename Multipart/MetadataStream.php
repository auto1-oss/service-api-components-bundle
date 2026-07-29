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

namespace Auto1\ServiceAPIComponentsBundle\Multipart;

use Psr\Http\Message\StreamInterface;

/**
 * PSR-7 stream decorator exposing multipart transport metadata under the METADATA_* keys.
 * The metadata is caller-supplied and unvalidated — do not use it for validation or authorization.
 */
class MetadataStream implements StreamInterface
{
    public const METADATA_MIME_TYPE = 'mime-type';
    public const METADATA_FILENAME = 'filename';

    private StreamInterface $inner;

    private ?string $filename;

    private ?string $mimeType;

    public function __construct(StreamInterface $inner, ?string $filename = null, ?string $mimeType = null)
    {
        $this->inner = $inner;
        $this->filename = $filename;
        $this->mimeType = $mimeType;
    }

    public function __toString(): string
    {
        return (string) $this->inner;
    }

    public function close(): void
    {
        $this->inner->close();
    }

    public function detach()
    {
        return $this->inner->detach();
    }

    public function getSize(): ?int
    {
        return $this->inner->getSize();
    }

    public function tell(): int
    {
        return $this->inner->tell();
    }

    public function eof(): bool
    {
        return $this->inner->eof();
    }

    public function isSeekable(): bool
    {
        return $this->inner->isSeekable();
    }

    public function seek(int $offset, int $whence = SEEK_SET): void
    {
        $this->inner->seek($offset, $whence);
    }

    public function rewind(): void
    {
        $this->inner->rewind();
    }

    public function isWritable(): bool
    {
        return $this->inner->isWritable();
    }

    public function write(string $string): int
    {
        return $this->inner->write($string);
    }

    public function isReadable(): bool
    {
        return $this->inner->isReadable();
    }

    public function read(int $length): string
    {
        return $this->inner->read($length);
    }

    public function getContents(): string
    {
        return $this->inner->getContents();
    }

    public function getMetadata(?string $key = null)
    {
        $metadata = [];

        if (null !== $this->mimeType) {
            $metadata[self::METADATA_MIME_TYPE] = $this->mimeType;
        }

        if (null !== $this->filename) {
            $metadata[self::METADATA_FILENAME] = $this->filename;
        }

        if (null === $key) {
            return array_merge((array) $this->inner->getMetadata(), $metadata);
        }

        return array_key_exists($key, $metadata) ? $metadata[$key] : $this->inner->getMetadata($key);
    }
}
