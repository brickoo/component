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

namespace Brickoo\Tests\Autoloader;

require_once "Fixture/AutoloaderConcrete.php";
use Brickoo\Autoloader\Exception\AutoloaderNotRegisteredException,
    Brickoo\Autoloader\Exception\DuplicateAutoloaderRegistrationException,
    Brickoo\Tests\Autoloader\Fixture\AutoloaderConcrete,
    PHPUnit_Framework_TestCase;

/**
 * Test suite for the Autoloader class.
 * @see Brickoo\Autoloader\Autoloader
 * @author Celestino Diaz <celestino.diaz@gmx.de>
 */

class AutoloaderTest extends PHPUnit_Framework_TestCase {

    /** @covers Brickoo\Autoloader\Autoloader::__construct */
    public function testConstructor() {
        $autoloader = new AutoloaderConcrete();
        $this->assertAttributeEquals(false, "isRegistered", $autoloader);
    }

    /** @covers Brickoo\Autoloader\Autoloader::register */
    public function testRegisterAutoloader() {
        $autoloader = new AutoloaderConcrete();
        $this->assertAttributeEquals(false, "isRegistered", $autoloader);
        $this->assertSame($autoloader, $autoloader->register());
        $this->assertAttributeEquals(true, "isRegistered", $autoloader);
        $this->assertTrue(spl_autoload_unregister(array($autoloader, "load")));
    }

    /**
     * @covers Brickoo\Autoloader\Autoloader::register
     * @covers Brickoo\Autoloader\Exception\DuplicateAutoloaderRegistrationException
     * @expectedException Brickoo\Autoloader\Exception\DuplicateAutoloaderRegistrationException
     */
    public function testRegistrationThrowsDuplicateAutoloaderRegistrationException() {
        $autoloader = new AutoloaderConcrete();
        try{
            $autoloader->register();
            $autoloader->register();
        }
        catch (DuplicateAutoloaderRegistrationException $Exception) {
            $this->assertTrue(spl_autoload_unregister(array($autoloader, "load")));
            throw $Exception;
        }
    }

    /** @covers Brickoo\Autoloader\Autoloader::unregister */
    public function testUnregisterAutoloader() {
        $autoloader = new AutoloaderConcrete();
        $autoloader->register();
        $this->assertAttributeEquals(true, "isRegistered", $autoloader);
        $this->assertSame($autoloader, $autoloader->unregister());
        $this->assertAttributeEquals(false, "isRegistered", $autoloader);
        $this->assertFalse(spl_autoload_unregister(array($autoloader, "load")));
    }

    /**
     * @covers Brickoo\Autoloader\Autoloader::unregister
     * @covers Brickoo\Autoloader\Exception\AutoloaderNotRegisteredException
     * @expectedException Brickoo\Autoloader\Exception\AutoloaderNotRegisteredException
     */
    public function testUnregisterThrowsAutoloaderNotRegisteredExeption() {
        $autoloader = new AutoloaderConcrete();
        try {
            $autoloader->unregister();
        }
        catch (AutoloaderNotRegisteredException $Exception) {
            $this->assertFalse(spl_autoload_unregister(array($autoloader, "load")));
            throw $Exception;
        }
    }

    /** @covers Brickoo\Autoloader\Autoloader::load */
    public function testAbstractLoadDummy() {
        $autoloader = new AutoloaderConcrete();
        $this->assertNull($autoloader->load("not implemented"));
    }

}