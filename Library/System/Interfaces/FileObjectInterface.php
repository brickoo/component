<?php

    /*
     * Copyright (c) 2008-2011, Celestino Diaz Teran <celestino@users.sourceforge.net>.
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

    namespace Brickoo\Library\System\Interfaces;

    /**
     * FileObjectInterface
     *
     * Interface for implementing the FileObject.
     * @author Celestino Diaz Teran <celestino@users.sourceforge.net>
     * @version $Id$
     */

    interface FileObjectInterface
    {

        /**
        * Returns the current location used.
        * @throws \UnexpectedValueException if no location has been assigned
        * @return string the current location
        */
        public function getLocation();

        /**
         * Sets the lcoation to use for file operations.
         * @param string $location the location to use
         * @return object reference
         */
        public function setLocation($location);

        /**
         * Returns the current mode used.
         * @throws \UnexpectedValueException if no mode has been assigned
         * @return string the current mode
         */
        public function getMode();

        /**
         * Sets the mode for the file operation.
         * @param string $mode the mode to use
         * @return object reference
         */
        public function setMode($mode);

        /**
        * Opens the file to store the resource handle.
        * @param string $location the location of the file to open
        * @param string $mode the mode to use
        * @throws Exceptions\ResourceAlreadyExistsException if the resource already exists
        * @throws Exceptions\UnableToCreateResource if the resource can not be created
        * @return reource the file handle resource
        */
        public function open($location, $mode);

        /**
         * Returns the current used resource or creates one if none is used.
         * @throws Exceptions\UnableToCreateResource if the resource cant be created
         * @return resource
         */
        public function getResource();

        /**
         * Checks if a resource has been created.
         * @return boolean check result
         */
        public function hasResource();

        /**
         * Removes the holded resource by closing the data pointer.
         * This method does not throw an exception like the explicit FileoBject::close does.
         * @return object reference
         */
        public function removeResource();

        /**
         * Writes the data into the file location.
         * @param integer|string $data the data to write
         * @return object reference;
         */
        public function write($data);

        /**
         * Reads the passed bytes of data from the file location.
         * @param integer the amount of bytes to read from
         * @return string the readed content
         */
        public function read($bytes);

        /**
         * Closes the the data handler and frees the ressource.
         * @throws Exceptions\ResourceNotAvailableException if the resource is not initialized
         * @return object reference
         */
        public function close();

        /**
        * Provides the posibility to call not implemented file operations.
        * @param string $function the function name to call
        * @param array $arguments the arguments to pass
        * @throws BadMethodCallException if trying to call fopen() or fclose()
        * @return mixed the calles function return value
        */
        public function __call($function, array $arguments);

    }

?>