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

    namespace Brickoo\Memory\Interfaces;

    /**
     * Registry
     *
     * Describes the methods implemented by this interface.
     * @author Celestino Diaz <celestino.diaz@gmx.de>
     */

    Interface Registry extends \Countable {

        /**
         * Returns all assigned registrations.
         * @return array the assigned registrations
         */
        public function getAll();

        /**
         * Adds a list of registrations to the registry.
         * @param array $registrations the registrations to add
         * @throws \InvalidArgumentException if passed registrations is empty
         * @return \Brickoo\Memory\Interfaces\Registry
         */
        public function add(array $registrations);

        /**
         * Returns the registered value from the given identifier.
         * @param string|integer $identifier the identifier so retrieve the value from
         * @throws \InvalidArgumentException if the identifier is not valid
         * @throws \Brickoo\Memory\Exceptions\IdentifierNotRegisteredException if the identifier is not registered
         * @return mixed the value of the registered identifier
         */
        public function get($identifier);

        /**
         * Register an identifer-value pair.
         * Take care of registering objects who are assigned somewhere else
         * as an reference the changes applys to the registerd objects as well.
         * @param string|integer $identifier the identifier to register
         * @param mixed $value the identifier value to reguister with
         * @throws \Brickoo\Memory\Exceptions\DuplicateRegistrationException the identifier is already registered
         * @throws \Brickoo\Memory\Exceptions\ReadonlyModeException if the mode is currently read only
         * @return \Brickoo\Memory\Interfaces\Registry
         */
        public function register($identifier, $value);

        /**
         * Overrides an existing identifier with the new value (!).
         * If the identifer ist not registered it will be registered.
         * @param string|integer $identifier the identifier to register
         * @param mixed $value the identifier value to register
         * @throws \Brickoo\Memory\Exceptions\ReadonlyModeException if the mode is currently read only
         * @throws \Brickoo\Memory\Exceptions\IdentifierLockedException if the identifier is locked
         * @return \Brickoo\Memory\Interfaces\Registry
         */
        public function override($identifier, $value);

        /**
         * Unregister the indentifier and his value.
         * @param string|integer $identifier the identifier to unregister
         * @throws \Brickoo\Memory\Exceptions\ReadonlyModeException if the mode is currently read only
         * @throws \Brickoo\Memory\Exceptions\IdentifierLockedException if the identifier is locked
         * @throws \Brickoo\Memory\Exceptions\IdentifierNotRegisteredException if the identifier is not registered
         * @return \Brickoo\Memory\Interfaces\Registry
         */
        public function unregister($identifier);


        /**
         * Check if the identifier is registered.
         * @param string|integer $identifier the identifier to check
         * @return boolean check result
         */
        public function isRegistered($identifier);

        /**
         * Sets the read only mode for all registrations.
         * True to allow read only, write operations will be not allowed.
         * False for enable read and write operations, locked identifiers will still being locked .
         * @param boolean $mode the mode to set
         * @return \Brickoo\Memory\Interfaces\Registry
         */
        public function setReadOnly($mode = true);

        /**
         * Check if the mode is currently set to read only.
         * @return boolean read only mode
         */
        public function isReadOnly();

    }