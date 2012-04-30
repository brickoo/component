<?php

    /*
     * Copyright (c) 2011-2012, Celestino Diaz <celestino.diaz@gmx.de>.
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
     * 3. Neither the name of Brickoo nor the names of its contributors may be used
     *    to endorse or promote products derived from this software without specific
     *    prior written permission.
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

    namespace Brickoo\Http\Component;

    use Brickoo\Memory,
        Brickoo\Validator\TypeValidator;

    /**
     * Query
     *
     * Implements methods to work with http queries.
     * @author Celestino Diaz <celestino.diaz@gmx.de>
     */

    class Query extends Memory\Container implements Interfaces\QueryInterface {

        /**
         * Importst the request query parameter.
         * @return \Brickoo\Http\Component\Query
         */
        public function importFromGlobals() {
            $this->merge($_GET);

            return $this;
        }

        /**
         * Imports the query parameters from query string.
         * @param string $query the query string to import from
         * @return \Brickoo\Http\Component\Query
         */
        public function importFromString($query) {
            TypeValidator::IsString($query);

            if (($position = strpos($query, '?')) !== false) {
                $query = substr($query, $position + 1);
            }

            parse_str($query, $imported);

            $this->merge($imported);

            return $this;
        }

        /**
         * Converts the query parameters to a request query string.
         * The values are encoded as of the RFC 1738.
         * @link http://www.faqs.org/rfcs/rfc1738.html
         * @return string the query string
         */
        public function toString() {
            $query = array();

            $this->rewind();
            while($this->valid()) {
                $query[] = rawurlencode($this->key()) . '=' . rawurlencode($this->current());
                $this->next();
            }

            return implode('&', $query);
        }

        /**
         * Supporting casting to string.
         * @return string the collected headers
         */
        public function __toString() {
            return $this->toString();
        }

    }