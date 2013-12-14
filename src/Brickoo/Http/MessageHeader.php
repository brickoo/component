<?php

/*
 * Copyright (c) 2011-2013, Celestino Diaz <celestino.diaz@gmx.de>.
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

namespace Brickoo\Http;

use Brickoo\Memory\Container;

/**
 * MessageHeader
 *
 * Implements a http message header container.
 * @author Celestino Diaz <celestino.diaz@gmx.de>
 */

class MessageHeader extends Container {

    /**
     * Sends the message headers to the output buffer.
     * @param callable $callback this argument should only be used for testing purposes
     * @return \Brickoo\Http\MessageHeader
     */
    public function send($callback = null) {
        $function = (is_callable($callback) ? $callback : "header");

        $header = $this->normalizeHeaders($this->toArray());
        foreach($header as $key => $value) {
            call_user_func($function, sprintf("%s: %s", $key, $value));
        }

        return $this;
    }

    /**
     * Coverts message headers to a request header string.
     * @return string the representation of the message headers
     */
    public function toString() {
        $headerString = "";

        $header = $this->normalizeHeaders($this->toArray());
        foreach($header as $key => $value) {
            $headerString .= sprintf("%s: %s\r\n", $key, $value);
        }

        return $headerString;
    }

    /**
     * Imports the headers from the request.
     * @return \Brickoo\Http\MessageHeader
     */
    public function importFromRequest() {
        $headers = array();
        $includeExceptions = array("CONTENT_TYPE", "CONTENT_LENGTH");

        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) == "HTTP_") {
                $headers[substr($key, 5)] = $value;
            }
            elseif (in_array($key, $includeExceptions)){
                $headers[$key] = $value;
            }
        }

        if (function_exists("apache_request_headers") && ($apacheHeaders = apache_request_headers())) {
            $headers = array_merge($headers, $apacheHeaders);
        }

        $this->fromArray($this->normalizeHeaders($headers));
        return $this;
    }

    /**
     * Imports the headery by extracting the header values from string.
     * @param string $headers the headers to extract the key/value pairs from
     * @throws \InvalidArgumentException
     * @return \Brickoo\Http\MessageHeader
     */
    public function importFromString($headers) {
        Argument::IsString($headers);

        $importedHeaders = array();
        $fields = explode("\r\n", preg_replace("/\x0D\x0A[\x09\x20]+/", " ", $headers));

        foreach ($fields as $field) {
            if (preg_match("/(?<name>[^:]+): (?<value>.+)/m", $field, $match)) {
                $importedHeaders[$match["name"]] = trim($match["value"]);
            }
        }

        $this->fromArray($this->normalizeHeaders($importedHeaders));
        return $this;
    }

    /**
     * Normalizes the headers keys.
     * @param array $headers the headers to normalized
     * @return array the normalized headers
     */
    private function normalizeHeaders(array $headers) {
        $normalizedHeaders = array();

        foreach ($headers as $headerName => $headerValue) {
            $headerName = str_replace(" ", "-", ucwords(
                strtolower(str_replace(array("_", "-"), " ", $headerName))
            ));
            $normalizedHeaders[$headerName] = $headerValue;
        }

        ksort($normalizedHeaders);
        return $normalizedHeaders;
    }

}