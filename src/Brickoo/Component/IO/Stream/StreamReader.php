<?php

/*
 * Copyright (c) 2011-2014, Celestino Diaz <celestino.diaz@gmx.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Brickoo\Component\IO\Stream;

use Brickoo\Component\IO\Stream\Exception\InvalidResourceHandleException,
    Brickoo\Component\IO\Stream\Exception\UnableToReadBytesException,
    Brickoo\Component\Validation\Argument;

/**
 * StreamReader
 *
 * Implements a stream reader.
 */
class StreamReader {

    /** @var resource */
    private $streamResource;

    /** @param resource $streamResource */
    public function __construct($streamResource) {
        Argument::IsResource($streamResource);
        $this->streamResource = $streamResource;
    }

    /**
     * Return the read bytes from the stream.
     * @param integer $bytes
     * @throws \InvalidArgumentException
     * @throws \Brickoo\Component\IO\Stream\Exception\InvalidResourceHandleException
     * @return string the read content
     */
    public function read($bytes = 1024) {
        Argument::IsInteger($bytes);

        if (! is_resource($this->streamResource)) {
            throw new InvalidResourceHandleException();
        }

        return (string)fread($this->streamResource, $bytes);
    }

    /**
     * Returns a line after the current stream pointer position.
     * @throws \Brickoo\Component\IO\Stream\Exception\UnableToReadBytesException
     * @throws \Brickoo\Component\IO\Stream\Exception\InvalidResourceHandleException
     * @return string
     */
    public function readLine() {
        if (! is_resource($this->streamResource)) {
            throw new InvalidResourceHandleException();
        }

        if (($content = fgets($this->streamResource)) === false) {
            throw new UnableToReadBytesException(fstat($this->streamResource)["size"]);
        }

        return $content;
    }

    /**
     * Returns the content of a file after the current stream pointer position.
     * @throws \Brickoo\Component\IO\Stream\Exception\InvalidResourceHandleException
     * @return string
     */
    public function readFile() {
        if (! is_resource($this->streamResource)) {
            throw new InvalidResourceHandleException();
        }

        return (string)stream_get_contents($this->streamResource);
    }

}
