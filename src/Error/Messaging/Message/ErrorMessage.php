<?php

/*
 * Copyright (c) 2011-2015, Celestino Diaz <celestino.diaz@gmx.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Brickoo\Component\Error\Messaging\Message;

use Brickoo\Component\Error\Messaging\Messages;
use Brickoo\Component\Messaging\GenericMessage;
use Brickoo\Component\Common\Assert;

/**
 * ErrorMessage
 *
 * Implementation of an error message.
 * @author Celestino Diaz <celestino.diaz@gmx.de>
 */
class ErrorMessage extends GenericMessage {

    /**
     * Error message parameter.
     * @var string
     */
    const PARAM_ERROR_MESSAGE = "errorMessage";

    /** @param string $errorMessage */
    public function __construct($errorMessage) {
        Assert::isString($errorMessage);
        parent::__construct(Messages::ERROR, null, [self::PARAM_ERROR_MESSAGE => $errorMessage]);
    }

    /**
     * Returns the message containing the error occurred.
     * @return string the error message
     */
    public function getErrorMessage() {
        return $this->getParam(self::PARAM_ERROR_MESSAGE);
    }

}
