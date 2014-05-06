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

namespace Brickoo\Tests\Component\Http;

use Brickoo\Component\Http\Header\AcceptCharsetHeader,
    PHPUnit_Framework_TestCase;

/**
 * AcceptCharsetHeaderTest
 *
 * Test suite for the AcceptCharsetHeader class.
 * @see Brickoo\Component\Http\Header\AcceptCharsetHeader
 * @author Celestino Diaz <celestino.diaz@gmx.de>
 */

class AcceptCharsetHeaderTest extends PHPUnit_Framework_TestCase {

    /**
     * @covers  Brickoo\Component\Http\Header\AcceptCharsetHeader::__construct
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorInvalidHeaderValueThrowsException() {
        new AcceptCharsetHeader(["wrongType"]);
    }

    /**
     * @covers  Brickoo\Component\Http\Header\AcceptCharsetHeader::__construct
     * @covers  Brickoo\Component\Http\Header\AcceptCharsetHeader::getCharsets
     * @covers  Brickoo\Component\Http\Header\CommonAcceptRoutines::getHeaderValues
     * @covers  Brickoo\Component\Http\Header\CommonAcceptRoutines::getExtractedHeaderValuesByRegex
     */
    public function testGetCharsets() {
        $acceptCharsetHeader = new AcceptCharsetHeader("utf-8,ISO-8859-1;q=0.9");
        $this->assertEquals(["utf-8" => 1.0, "ISO-8859-1" => 0.9], $acceptCharsetHeader->getCharsets());
    }

    /**
     * @covers  Brickoo\Component\Http\Header\AcceptCharsetHeader::setCharset
     * @covers  Brickoo\Component\Http\Header\AcceptCharsetHeader::getCharsets
     * @covers  Brickoo\Component\Http\Header\CommonAcceptRoutines::getHeaderValues
     * @covers  Brickoo\Component\Http\Header\CommonAcceptRoutines::getExtractedHeaderValuesByRegex
     * @covers  Brickoo\Component\Http\Header\CommonAcceptRoutines::buildValue
     */
    public function testSetCharsetsToExistingOnes() {
        $acceptCharsetHeader = new AcceptCharsetHeader("utf-8");
        $this->assertEquals(["utf-8" => 1.0], $acceptCharsetHeader->getCharsets());
        $this->assertSame($acceptCharsetHeader, $acceptCharsetHeader->setCharset("ISO-8859-1", 0.9));
        $this->assertEquals(["utf-8" => 1.0, "ISO-8859-1" => 0.9], $acceptCharsetHeader->getCharsets());
        $this->assertEquals("utf-8, ISO-8859-1;q=0.9", $acceptCharsetHeader->getValue());
    }

    /**
     * @covers  Brickoo\Component\Http\Header\AcceptCharsetHeader::isCharsetSupported
     * @covers  Brickoo\Component\Http\Header\AcceptCharsetHeader::getCharsets
     * @covers  Brickoo\Component\Http\Header\CommonAcceptRoutines::getHeaderValues
     * @covers  Brickoo\Component\Http\Header\CommonAcceptRoutines::getExtractedHeaderValuesByRegex
     */
    public function testIsCharsetSupported() {
        $acceptCharsetHeader = new AcceptCharsetHeader("utf-8");
        $this->assertTrue($acceptCharsetHeader->isCharsetSupported("utf-8"));
        $this->assertFalse($acceptCharsetHeader->isCharsetSupported("ISO-8859-1"));
    }

}