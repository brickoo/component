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

namespace Brickoo\Component\Http\Resolver\Plugin;

use Brickoo\Component\Http\Resolver\HeaderResolverPlugin;
use Brickoo\Component\Validation\Argument;

/**
 * StringHeaderResolverPlugin
 *
 * Implements a http header resolver plugin based on a header string.
 * @author Celestino Diaz <celestino.diaz@gmx.de>
 */

class StringHeaderResolverPlugin implements HeaderResolverPlugin {

    /** @var string */
    private $headers;

    /**
     * Class constructor.
     * @param string $headers the message headers as string
     */
    public function __construct($headers) {
        Argument::IsString($headers);
        $this->headers = $headers;
    }

    /** {@inheritDoc} */
    public function getHeaders() {
        $extractedHeaders = [];
        $fields = explode("\r\n", preg_replace("/\x0D\x0A[\x09\x20]+/", " ", $this->headers));

        foreach ($fields as $field) {
            $matches = [];
            if (preg_match("/(?<name>[^:]+): (?<value>.+)/m", $field, $matches) == 1) {
                $extractedHeaders[$matches["name"]] = trim($matches["value"]);
            }
        }
        return $extractedHeaders;
    }

}
