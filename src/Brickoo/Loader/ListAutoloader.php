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

    namespace Brickoo\Loader;

    /**
     * ListAutoloader
     *
     * Implementation of an autoloader to register mapping classes to a location.
     * @author Celestino Diaz <celestino.diaz@gmx.de>
     */

    class ListAutoloader extends Autoloader implements Interfaces\ListAutoloader {

        /** @var array */
        private $classes;

        /**
         * Class constructor.
         * @param array $classes the class to register as className, location pairs.
         * @param boolean $prepend flag to prepend or append to the PHP autoloader list
         * @return void
         */
        public function __construct(array $classes = array(), $prepend = true) {
            $this->classes = $classes;
            parent::__construct($prepend);
        }

        /** {@inheritDoc} */
        public function registerClass($className, $location) {
            if ((! is_string($className)) || empty($className) || (! is_string($location))) {
                throw new \InvalidArgumentException('The arguments should be non empty strings.');
            }

            if (! file_exists($location)) {
                require_once 'Exceptions/FileDoesNotExist.php';
                throw new Exceptions\FileDoesNotExist($location);
            }

            if ($this->isClassRegistered($className)) {
                require_once 'Exceptions/DuplicateClassRegistration.php';
                throw new Exceptions\DuplicateClassRegistration($className);
            }

            $this->classes[$className] = $location;
            return $this;
        }

        /** {@inheritDoc} */
        public function unregisterClass($className) {
            if (! is_string($className)) {
                throw new \InvalidArgumentException('The class name is not valid. Non empty string expected.');
            }

            if (! $this->isClassRegistered($className)) {
                throw new Exceptions\ClassNotRegistered($className);
            }

            unset($this->classes[$className]);
            return $this;
        }

        /** {@inheritDoc} */
        public function isClassRegistered($className) {
            if (! is_string($className)) {
                throw new \InvalidArgumentException('The class name is not valid. Non empty string expected.');
            }

            return isset($this->classes[$className]);
        }

        /** {@inheritDoc} */
        public function getRegisteredClasses() {
            return $this->classes;
        }

        /** {@inheritDoc} */
        public function load($className) {
            if (! is_string($className)) {
                throw new \InvalidArgumentException('The class name is not valid. Non empty string expected.');
            }

            if (! $this->isClassRegistered($className)) {
                return false;
            }

            $classFilePath = $this->classes[$className];

            if ((! file_exists($classFilePath))) {
                require_once 'Exceptions/FileDoesNotExist.php';
                throw new Exceptions\FileDoesNotExist($classFilePath);
            }

            require $classFilePath;
            return true;
        }

    }