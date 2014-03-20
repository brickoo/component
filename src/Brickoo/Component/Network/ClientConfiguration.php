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

namespace Brickoo\Component\Network;

use Brickoo\Component\Validation\Argument;

/**
 * ClientConfiguration
 *
 * Implements a network client configuration.
 * @author Celestino Diaz <celestino.diaz@gmx.de>
 */

class ClientConfiguration {

    /** @var string */
    private $serverAddress;

    /** @var integer */
    private $serverPort;

    /** @var integer */
    private $connectionTimeout;

    /** @var integer */
    private $connectionType;

    /** @var array */
    private $contextOptions;

    /**
     * Class constructor.
     * @param string $address
     * @param integer $port
     * @param integer $timeout
     * @param int $connectionType
     * @param array|null|resource $context
     */
    public function __construct($address, $port, $timeout = 30, $connectionType = STREAM_CLIENT_CONNECT, array $context = []) {
        Argument::IsString($address);
        Argument::IsInteger($timeout);
        Argument::IsInteger($connectionType);

        $this->serverAddress = $address;
        $this->serverPort = $port;
        $this->connectionTimeout = $timeout;
        $this->connectionType = $connectionType;
        $this->contextOptions = $context;
    }

    /**
     * Returns the server address.
     * @return string the server address
     */
    public function getAddress() {
        return $this->serverAddress;
    }

    /**
     * Returns the server port number.
     * @return integer the server port number
     */
    public function getPort() {
        return $this->serverPort;
    }

    /**
     * Returns the complete socket address.
     * @return string the socket address
     */
    public function getSocketAddress() {
        return sprintf("%s:%d", $this->getAddress(), $this->getPort());
    }

    /**
     * Returns the connection timeout.
     * @return integer the connection timeout
     */
    public function getConnectionTimeout() {
        return $this->connectionTimeout;
    }

    /**
     * Return one of the connection type flags.
     * @return integer the connection type
     */
    public function getConnectionType() {
        return $this->connectionType;
    }

    /**
     * Returns the connection context options.
     * @return array the connection context options
     */
    public function getContextOptions() {
        return $this->contextOptions;
    }

}
