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

namespace Brickoo\Tests\Component\Routing\Route;

use Brickoo\Component\Routing\Route\RequestRoute;
use PHPUnit_Framework_TestCase;

/**
 * RequestRouteTest
 *
 * Test suite for the RequestRoute class.
 * @see Brickoo\Component\Routing\Route\RequestRoute
 * @author Celestino Diaz <celestino.diaz@gmx.de>
 */

class RequestRouteTest extends PHPUnit_Framework_TestCase {

    /**
     * @covers Brickoo\Component\Routing\Route\RequestRoute::__construct
     * @covers Brickoo\Component\Routing\Route\RequestRoute::getRoute
     */
    public function testGetRoute() {
        $route = $this->getRouteStub();
        $executableRoute = new RequestRoute($route);
        $this->assertSame($route, $executableRoute->getRoute());
    }

    /** @covers Brickoo\Component\Routing\Route\RequestRoute::getParameters */
    public function testGetParameters() {
        $expectedParameters = ["param" => "the parameter value"];

        $executableRoute = new RequestRoute($this->getRouteStub(), $expectedParameters);
        $this->assertEquals($expectedParameters, $executableRoute->getParameters());
    }

    /** @covers Brickoo\Component\Routing\Route\RequestRoute::getParameter */
    public function testGetParameter() {
        $parameters = ["param" => "the parameter value"];

        $executableRoute = new RequestRoute($this->getRouteStub(), $parameters);
        $this->assertEquals($parameters["param"], $executableRoute->getParameter("param"));
    }

    /**
     * @covers Brickoo\Component\Routing\Route\RequestRoute::getParameter
     * @expectedException \InvalidArgumentException
     */
    public function testGetParameterThrowsInvalidArgumentException() {
        $executableRoute = new RequestRoute($this->getRouteStub());
        $executableRoute->getParameter(["wrongType"]);
    }

    /**
     * @covers Brickoo\Component\Routing\Route\RequestRoute::getParameter
     * @covers Brickoo\Component\Routing\Route\Exception\ParameterNotAvailableException
     * @expectedException \Brickoo\Component\Routing\Route\Exception\ParameterNotAvailableException
     */
    public function testGetParameterThrowsParameterNotAvailableException() {
        $executableRoute = new RequestRoute($this->getRouteStub());
        $executableRoute->getParameter("not.available");
    }

    /** @covers Brickoo\Component\Routing\Route\RequestRoute::hasParameter */
    public function testHasParameter() {
        $parameters = ["param" => "the parameter value"];

        $executableRoute = new RequestRoute($this->getRouteStub(), $parameters);
        $this->assertFalse($executableRoute->hasParameter("not.available"));
        $this->assertTrue($executableRoute->hasParameter("param"));
    }

    /**
     * @covers Brickoo\Component\Routing\Route\RequestRoute::hasParameter
     * @expectedException \InvalidArgumentException
     */
    public function testHasParameterThrowsInvalidArgumentException() {
        $executableRoute = new RequestRoute($this->getRouteStub());
        $executableRoute->hasParameter(["wrongType"]);
    }

    /**
     * Returns a route stub.
     * @return \Brickoo\Component\Routing\Route\Route
     */
    private function getRouteStub() {
        return $this->getMockBuilder("\\Brickoo\\Component\\Routing\\Route\\Route")
           ->disableOriginalConstructor()
            ->getMock();
    }

}
