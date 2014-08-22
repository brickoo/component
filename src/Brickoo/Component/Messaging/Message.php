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
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO message SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Brickoo\Component\Messaging;

/**
 * Message
 *
 * Defines a message holding corresponding parameters and sender reference.
 * @author Celestino Diaz <celestino.diaz@gmx.de>
 */

interface Message {

    /**
     * Returns the message name.
     * @return string the message name
     */
    public function getName();

    /**
     * Returns the sender object reference which triggered the message.
     * @return object the sender object reference or null if not set
     */
    public function getSender();

    /**
     * Stops the message of been called by other listeners.
     * @return \Brickoo\Component\Messaging\Message
     */
    public function stop();

    /**
     * Checks if the message has been stopped.
     * @return boolean check result
     */
    public function isStopped();

    /**
     * Returns the message parameters.
     * @return array the assigned message parameters
     */
    public function getParams();

    /**
     * Returns the parameter value of the identifier.
     * If the parameter does not exist, the default value is returned.
     * @param string $identifier the identifier to return the value from
     * @param mixed $defaultValue
     * @return mixed the parameter value or null if not set
     */
    public function getParam($identifier, $defaultValue = null);

    /**
     * Checks if the identifier is a available message parameter.
     * @param string $identifier the identifier to check the availability
     * @return boolean check result
     */
    public function hasParam($identifier);

    /**
     * Checks if the arguments are available message parameters.
     * Accepts any string arguments to check
     * @return boolean check result
     */
    public function hasParams();

    /**
     * Returns the message response.
     * @throws \Brickoo\Component\Messaging\Exception\ResponseNotAvailableException
     * @return \Brickoo\Component\Messaging\MessageResponseCollection $responseCollection
     */
    public function getResponse();

    /**
     * Sets the message response.
     * @param \Brickoo\Component\Messaging\MessageResponseCollection $response
     * @return \Brickoo\Component\Messaging\Message
     */
    public function setResponse(MessageResponseCollection $response);

}
