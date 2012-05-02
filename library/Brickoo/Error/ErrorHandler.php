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

    namespace Brickoo\Error;

    use Brickoo\Log,
        Brickoo\Event,
        Brickoo\Validator\TypeValidator;

    /**
     * ErrorHandler
     *
     * Handles user defined and system errors.
     * Errors can be logged using an instance implementing the LogHandler.
     * Otherwise throws an exception if the error level is expected.
     * @author Celestino Diaz <celestino.diaz@gmx.de>
     */

    class ErrorHandler {

        /**
         * Holds the bitwise error level to convert erros to exceptions.
         * @var integer
         */
        protected $errorLevel;

        /**
         * Returns the current error level.
         * @return integer the current error level
         */
        public function getErrorLevel() {
            return $this->errorLevel;
        }

        /**
         * Sets the bitwise error level to convert errors to exceptions.
         * @param integer $errorLevel the error level to set
         * @throws InvalidArgumentException if the argument is not an integer
         * @return \Brickoo\Error\ErrorHandler
         */
        public function setErrorLevel($errorLevel) {
            TypeValidator::IsInteger($errorLevel);

            $this->errorLevel = $errorLevel;

            return $this;
        }

        /**
         * Holds the status of instance registration as error handler.
         * @var boolean
         */
        protected $isRegistered;

        /**
         * Checks if the instance is registered as an error handler.
         * @return boolean check result
         */
        public function isRegistered() {
            return ($this->isRegistered === true);
        }

        /**
         * Registers the instance as error handler.
         * @throws DuplicateHandlerRegistrationException if the instance is already registred
         * @return \Brickoo\Error\ErrorHandler
         */
        public function register() {
            if ($this->isRegistered()) {
                throw new Exceptions\DuplicateHandlerRegistrationException('ErrorHandler');
            }

            set_error_handler(array($this, 'handleError'), (E_ALL | E_STRICT));
            $this->isRegistered = true;

            return $this;
        }

        /**
         * Unregisters the instance as error handler by restoring previous error handler.
         * @throws HandlerNotRegisteredException if the instance is not registred as handler
         * @return \Brickoo\Error\ErrorHandler
         */
        public function unregister() {
            if (! $this->isRegistered()) {
                throw new Exceptions\HandlerNotRegisteredException('ErrorHandler');
            }

            restore_error_handler();
            $this->isRegistered = false;

            return $this;
        }

        /**
         * Class constructor.
         * Initializes the class properties.
         * @return void
         */
        public function __construct() {
            $this->isRegistered    = false;
            $this->errorLevel      = 0;
        }

        /**
         * Handles the error reported by the user or system.
         * Notifies a log event containing the exception message.
         * @param integer $errorCode the error code number
         * @param string $errorMessage the error message
         * @param string $errorFile the error file name
         * @param integer $errorLine the error line number
         * @throws ErrorHandlerException if the error level matches
         * @return boolean true to block php error message forwarding
         */
        public function handleError($errorCode, $errorMessage, $errorFile, $errorLine) {
            $message = $errorMessage . ' throwed in ' . $errorFile . ' on line ' . $errorLine;

            Event\Manager::Instance()->notify(new Event\Event(Log\Events::LOG, $this, array(
                'messages' => $message
            )));

            if (($errorCode & $this->errorLevel) !== 0) {
                throw new Exceptions\ErrorHandlerException($message);
            }

            return true;
        }

    }