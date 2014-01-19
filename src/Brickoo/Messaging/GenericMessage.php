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

namespace Brickoo\Messaging;

use Brickoo\Messaging\Message,
    Brickoo\Messaging\Exception\ResponseNotAvailableException,
    Brickoo\Validation\Argument;

/**
 * Implements a generic event which can be used or extended by any component.
 * @author Celestino Diaz <celestino.diaz@gmx.de>
 */

class GenericMessage implements Message {

    /** @var string */
    private $name;

    /** @var array */
    private $params;

    /** @var object */
    private $sender;

    /** @var boolean */
    private $stopped;

    /** @var \Brickoo\Messaging\MessageResponseCollection */
    private $response;

    /**
     * @param string $name the message name
     * @param object $sender the sender object
     * @param array $parameters the parameters to add to the event
     * @throws \InvalidArgumentException
     */
    public function __construct($name, $sender = null, array $parameters = []) {
        Argument::IsString($name);

        if ($sender !== null) {
            Argument::IsObject($sender);
        }

        $this->name = $name;
        $this->sender = $sender;
        $this->params = $parameters;
        $this->stopped = false;
    }

    /** {@inheritDoc} */
    public function getSender() {
        return $this->sender;
    }

    /** {@inheritDoc} */
    public function stop() {
        $this->stopped = true;
        return $this;
    }

    /** {@inheritDoc} */
    public function isStopped() {
        return ($this->stopped === true);
    }

    /** {@inheritDoc} */
    public function getName() {
        return $this->name;
    }

    /** {@inheritDoc} */
    public function getParams() {
        return $this->params;
    }

    /** {@inheritDoc} */
    public function getParam($identifier, $defaultValue = null) {
        Argument::IsString($identifier);

        if (! $this->hasParam($identifier)) {
            return $defaultValue;
        }

        return $this->params[$identifier];
    }

    /** {@inheritDoc} */
    public function hasParam($identifier) {
        Argument::IsString($identifier);
        return isset($this->params[$identifier]);
    }

    /** {@inheritDoc} */
    public function hasParams() {
        $containsAllParameters = true;
        if (($arguments = func_get_args())) {
            foreach ($arguments as $argument) {
                if (! $this->hasParam($argument)) {
                    $containsAllParameters = false;
                    break;
                }
            }
        }
        return $containsAllParameters;
    }

    /** {@inheritDoc} */
    public function getResponse() {
        if ($this->response === null) {
            throw new ResponseNotAvailableException();
        }
        return $this->response;
    }

    /** {@inheritDoc} */
    public function setResponse(MessageResponseCollection $response) {
        $this->response = $response;
        return $this;
    }

}