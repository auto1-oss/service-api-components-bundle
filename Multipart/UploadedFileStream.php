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
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * The exposed MIME type and filename are the client-supplied, unvalidated ones — do not use
 * them for validation or authorization. UploadedFile::getMimeType() is the content-guessed one.
 */
final class UploadedFileStream extends MetadataStream
{
    private UploadedFile $uploadedFile;

    public function __construct(StreamInterface $inner, UploadedFile $uploadedFile)
    {
        parent::__construct(
            $inner,
            $uploadedFile->getClientOriginalName(),
            $uploadedFile->getClientMimeType()
        );

        $this->uploadedFile = $uploadedFile;
    }

    /**
     * Escape hatch for code that needs Symfony-specific file operations
     */
    public function getUploadedFile(): UploadedFile
    {
        return $this->uploadedFile;
    }
}
