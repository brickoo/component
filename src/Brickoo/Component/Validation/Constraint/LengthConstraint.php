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

namespace Brickoo\Component\Validation\Constraint;

use Brickoo\Component\Validation\Argument,
    Brickoo\Component\Validation\Constraint;

/**
 * LengthConstraint
 *
 * Constraint to assert that the string value length
 * is between a min and max length.
 * @author Celestino Diaz <celestino.diaz@gmx.de>
 */

class LengthConstraint implements Constraint {

    /** @var integer */
    private $minLength;

    /** @var integer */
    private $maxLength;

    /**
     * Class constructor.
     * @param integer $minLength
     * @param Integer $maxLength
     */
    public function __construct($minLength, $maxLength = null) {
        Argument::IsInteger($minLength);
        Argument::IsInteger($maxLength);
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }

    /** {@inheritDoc} */
    public function matches($value) {
        Argument::IsString($value);
        $valueLength = strlen($value);

        return ($valueLength >= $this->minLength
            && ($this->maxLength === null || $valueLength <= $this->maxLength)
        );
    }

}