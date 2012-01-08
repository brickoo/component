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

    namespace Brickoo\Library\Http\Interfaces;

    /**
     * RequestInterface
     *
     * Describes the methods implemented by this interface.
     * @author Celestino Diaz <celestino.diaz@gmx.de>
     */

    Interface RequestInterface
    {

        /**
         * Lazy initialization of the Core\Request instance.
         * Returns the Core\Request instance.
         * @return object Core\Request implementing the Core\Interfaces\RequestInterface
         */
        public function getCoreRequest();

        /**
         * Injects the Core\Request dependency.
         * @param \Brickoo\Library\Core\Interfaces\RequestInterface $CoreRequest the Core\Request instance
         * @throws Core\Exceptions\DependencyOverwriteException if trying to overwrite the dependecy
         * @return object reference
         */
        public function injectCoreRequest(\Brickoo\Library\Core\Interfaces\RequestInterface $CoreRequest);

        /**
         * Lazy initialization of the Url instance.
         * Returns the Url object implementing the UrlInterface.
         * @return object Url implementing the UrlInterface
         */
        public function Url();

        /**
         * Injects the Url dependency used for Url specific tasks.
         * @param UrlInterface $Url the Url object implementing the UrlInterface
         * @throws Core\Exceptions\DependencyOverwriteException if trying to overwrite the dependecy
         * @return object reference
         */
        public function injectUrl(\Brickoo\Library\Http\Interfaces\UrlInterface $Url);

        /**
         * Returns the current request variables order.
         * @return array containing the variables order
         */
        public function getVariablesOrder();

        /**
         * Sets the request variables order to use.
         * @param string $order the collecting order
         * @return object reference
         */
        public function setVariablesOrder($order);

        /**
         * Returns all available request parameters like the superglobal
         * $_REQUEST variable does with the order previously set.
         * The Parameters are returned as an associative array.
         * @return array the request parameters
         */
        public function getParams();

        /**
         * Returns the value of the given request parameter.
         * @param string $paramName the parameter name
         * @param mixed $defaultValue the default value to return
         * @return string the request parameter value or the default value
         */
        public function getParam($paramName, $defaultValue = null);

        /**
         * Add headers to the current available http headers.
         * @param array $headers the key-value pairs to add
         * @param boolean $override flag to force overriding
         * @return object reference
         */
        public function addHTTPHeaders(array $headers, $override = false);

        /**
         * Returns all available http headers.
         * @return array the available http headers
         */
        public function getHTTPHeaders();

        /**
         * Return the value of the given http header if available.
         * @param string $headerName the header name to retrieve the value from
         * @param mixed $defaultValue the default value to return
         * @return string/mixed the header or the default value
         */
        public function getHTTPHeader($headerName, $defaultValue = null);

        /**
         * Check if the given http header name is available.
         * @param string $headerName the http header name to check
         * @return boolean check result
         */
        public function isHTTPHeaderAvailable($headerName);

        /**
         * Returns the accept types supported by the request client.
         * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.1
         * @param string $neededType the type which is needed if supported
         * @return array accept types sorted by priority descening
         * or the supported types otherwise
         */
        public function getAcceptTypes();

        /**
         * Checks if the passed type is supported.
         * @param string $acceptType the accept type to check
         * @return boolean check result
         */
        public function isTypeSupported($acceptType);

        /**
         * Returns the accept languages supported by the request client.
         * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4
         * @return array the languages sorted by priority descening
         */
        public function getAcceptLanguages();

        /**
         * Checks if the passed language is supported.
         * @param string $acceptLanguage the accept language to check
         * @return boolean check result
         */
        public function isLanguageSupported($acceptLanguage);

        /**
         * Returns the accept encodings supported by the request client.
         * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.3
         * @return array the encondings sorted by priority descening
         */
        public function getAcceptEncodings();

        /**
         * Checks if the passed encoding type is supported.
         * @param string $acceptEncoding the accept encoding type to check
         * @return boolean check result
         */
        public function isEncodingSupported($acceptEncoding);

        /**
         * Returns the accept charsets supported by the request client.
         * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.2
         * @return array the charsets sorted by priority descening
         */
        public function getAcceptCharsets();

        /**
         * Checks if the passed encoding type is supported.
         * @param string $acceptEncoding the accept encoding type to check
         * @return boolean check result
         */
        public function isCharsetSupported($acceptCharset);

        /**
         * Returns the accept header value sorted by quality.
         * @param string $regex the regular expression to use
         * @param string $keyName the key name to assign the quality to
         * @param string $acceptHeader the accept header to retireve the values from
         * @return array the result containing the header values
         */
        public function getAcceptHeaderByRegex($regex, $keyName, $acceptHeader);

        /**
         * Resets the Request object properties.
         * @return object reference
         */
        public function reset();

        /**
        * Returns the raw body of the request.
         * @return string
        */
        public function getRawBody();

        /**
        * Checks if the connection is based on https.
        * @return boolean check result
        */
        public function isSecureConnection();

        /**
        * Check if the Ajax framework has sent an identifier.
        * This is not standard and is currently just supported by few javascript frameworks.
        * @return boolean check result
             */
        public function isAjaxRequest();

    }

?>