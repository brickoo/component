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

namespace Brickoo\Component\Validation;

use InvalidArgumentException;

/**
 * Argument
 * Validates an argument by expectation and
 * throws an \InvalidArgumentException if the validation fails.
 * @author Celestino Diaz <celestino.diaz@gmx.de>
 */

class Argument {

    /** @var boolean */
    public static $throwExceptions = true;

    /**
     * Check if the argument is a string and not empty, accepts empty strings.
     * @param string $argument the arguments to validate
     * @throws \InvalidArgumentException if the validation fails
     * @return boolean check result
     */
    public static function isString($argument) {
        return self::handleArgumentValidation(is_string($argument),
            $argument, "The argument must be of type string."
        );
    }

    /**
     * Check if the argument is an integer.
     * @param integer $argument the argument to check
     * @throws \InvalidArgumentException if the validation fails
     * @return boolean check result
     */
    public static function isInteger($argument) {
        return self::handleArgumentValidation(is_int($argument),
            $argument, "The argument must be of type integer."
        );
    }

    /**
     * Check if the argument is a string or a integer, accepts empty values.
     * @param string $argument the argument to validate
     * @throws \InvalidArgumentException if the validation fails
     * @return boolean check result
     */
    public static function isStringOrInteger($argument) {
        return self::handleArgumentValidation(
            (is_string($argument) || is_int($argument)),
            $argument, "The argument must be of type integer or string."
        );
    }

    /**
     * Check if the arguments is a float.
     * @param float $argument the argument to check
     * @throws \InvalidArgumentException if the validation fails
     * @return boolean check result
     */
    public static function isFloat($argument) {
        return self::handleArgumentValidation(is_float($argument),
            $argument, "The argument must be of type float."
        );
    }

    /**
     * Check if the argument is a boolean.
     * @param boolean $argument the argument to validate
     * @throws \InvalidArgumentException if the validation fails
     * @return boolean check result
     */
    public static function isBoolean($argument) {
        return self::handleArgumentValidation(is_bool($argument),
            $argument, "The argument must be of type boolean."
        );
    }

    /**
     * Check if the argument is not empty.
     * @param mixed $argument the argument to validate
     * @throws \InvalidArgumentException if the validation fails
     * @return boolean check result
     */
    public static function isNotEmpty($argument) {
        return self::handleArgumentValidation((! empty($argument)),
            $argument, "The argument must not be empty."
        );
    }

    /**
     * Check if a function is available by its name.
     * @param string $argument the argument to validate
     * @throws \InvalidArgumentException if the validation fails
     * @return boolean check result
     */
    public static function isFunctionAvailable($argument) {
        return self::handleArgumentValidation(function_exists($argument),
            $argument, "The argument must be an available function."
        );
    }

    /**
     * Check if the argument is traversable.
     * @param \Traversable|array $argument the argument to validate
     * @throws \InvalidArgumentException if the validation fails
     * @return boolean check result
     */
    public static function isTraversable($argument) {
        return self::handleArgumentValidation(
            (is_array($argument) || ($argument instanceof \Traversable)),
            $argument, "The argument must be traversable."
        );
    }

    /**
     * Check if the argument is callable.
     * @param callable $argument the argument to validate
     * @throws \InvalidArgumentException if the validation fails
     * @return boolean check result
     */
    public static function isCallable($argument) {
        return self::handleArgumentValidation(is_callable($argument),
            $argument, "The argument must be callable."
        );
    }

    /**
     * Check if the argument is an object.
     * @param object $argument the argument to validate
     * @throws \InvalidArgumentException if the validation fails
     * @return boolean check result
     */
    public static function isObject($argument) {
        return self::handleArgumentValidation(is_object($argument),
            $argument, "The argument must be an object."
        );
    }

    /**
     * Check if the argument is a resource.
     * @param resource $argument the argument to validate
     * @throws \InvalidArgumentException if the validation fails
     * @return boolean check result
     */
    public static function isResource($argument) {
        return self::handleArgumentValidation(is_resource($argument),
            $argument, "The argument must be a resource."
        );
    }

    /**
     * Handle an invalid argument.
     * @param boolean $validationSuccess
     * @param mixed $argument
     * @param string $errorMessage
     * @throws \InvalidArgumentException
     * @return boolean false if exception is turned off
     */
    public static function handleArgumentValidation($validationSuccess, $argument, $errorMessage) {
        if ($validationSuccess) {
            return true;
        }

        if (self::$throwExceptions) {
            throw self::getInvalidArgumentException($argument, $errorMessage);
        }
        trigger_error(self::getErrorMessage($argument, $errorMessage), E_USER_WARNING);
        return false;
    }

    /**
     * Throw an \InvalidArgumentException describing the argument and adding a helpful error message.
     * @param mixed $argument the arguments which are invalid
     * @param string $errorMessage the error message to attach
     * @return \InvalidArgumentException
     */
    public static function getInvalidArgumentException($argument, $errorMessage) {
        return new InvalidArgumentException(self::getErrorMessage($argument, $errorMessage));
    }

    /**
     * Return the formatted error message.
     * @param mixed $argument
     * @param string $errorMessage
     * @return string the error message
     */
    private static function getErrorMessage($argument, $errorMessage) {
        return sprintf(
            "Unexpected argument %s. %s",
            self::getArgumentStringRepresentation($argument),
            $errorMessage
        );
    }

    /**
     * Return the argument string representation.
     * @param mixed $argument the argument to return the representation
     * @return string the argument representation
     */
    private static function getArgumentStringRepresentation($argument) {
        switch (gettype($argument)) {
            case "object":
                $representation = sprintf("[object #%s] %s", spl_object_hash($argument), get_class($argument));
                break;
            default:
                $representation = sprintf(
                    "[%s] %s",
                    gettype($argument),
                    str_replace(["\r", "\n", " "], "", var_export($argument, true))
                );
        }
        return $representation;
    }

}
