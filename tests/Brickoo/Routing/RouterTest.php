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

namespace Brickoo\Tests\Routing;

use ArrayIterator,
    Brickoo\Routing\Router,
    PHPUnit_Framework_TestCase;

/**
 * RouterTest
 *
 * Test suite for the Router class.
 * @see Brickoo\Routing\Router
 * @author Celestino Diaz <celestino.diaz@gmx.de>
 */

class RouterTest extends PHPUnit_Framework_TestCase {

    /**
     * @covers Brickoo\Routing\Router::__construct
     * @covers Brickoo\Routing\Router::getRoute
     * @covers Brickoo\Routing\Router::getRouteCollectorIterator
     */
    public function testGetRouteWithoutCollectionName() {
        $route = $this->getRouteStub();

        $routeCollection = $this->getRouteCollectionStub();
        $routeCollection->expects($this->any())
                        ->method("hasRoute")
                        ->with("unit.test.route")
                        ->will($this->returnValue(true));
        $routeCollection->expects($this->any())
                        ->method("getRoute")
                        ->with("unit.test.route")
                        ->will($this->returnValue($route));

        $router = new Router($this->getRouteCollectorStub($routeCollection), $this->getRouteMatcherMock());
        $this->assertSame($route, $router->getRoute("unit.test.route"));
    }

    /**
     * @covers Brickoo\Routing\Router::getRoute
     * @covers Brickoo\Routing\Router::getRouteCollectorIterator
     * @covers Brickoo\Routing\Router::isCollectionResponsible
     */
    public function testGetRouteWithCollectionName() {
        $collectionName = "unit-test-collection";

        $route = $this->getRouteStub();

        $routeCollection = $this->getRouteCollectionStub();
        $routeCollection->expects($this->any())
                        ->method("hasName")
                        ->will($this->returnValue(true));
        $routeCollection->expects($this->any())
                        ->method("getName")
                        ->will($this->returnValue($collectionName));
        $routeCollection->expects($this->any())
                        ->method("hasRoute")
                        ->with("unit.test.route")
                        ->will($this->returnValue(true));
        $routeCollection->expects($this->any())
                        ->method("getRoute")
                        ->with("unit.test.route")
                        ->will($this->returnValue($route));

        $router = new Router($this->getRouteCollectorStub($routeCollection), $this->getRouteMatcherMock());
        $this->assertSame($route, $router->getRoute("unit.test.route", $collectionName));
    }

    /**
     * @covers Brickoo\Routing\Router::getRoute
     * @covers Brickoo\Routing\Router::getRouteCollectorIterator
     * @covers Brickoo\Routing\Exception\RouteNotFoundException
     * @expectedException Brickoo\Routing\Exception\RouteNotFoundException
     */
    public function testGetRouteThrowsRouteNotFoundException() {
        $routeCollection = $this->getRouteCollectionStub();
        $routeCollection->expects($this->any())
                        ->method("hasRoute")
                        ->with("unit.test.route")
                        ->will($this->returnValue(false));

        $router = new Router($this->getRouteCollectorStub($routeCollection), $this->getRouteMatcherMock());
        $router->getRoute("unit.test.route");
    }

    /**
     * @covers Brickoo\Routing\Router::getRoute
     * @expectedException InvalidArgumentException
     */
    public function testGetRouteThrowsInvalidArgumentException() {
        $router = new Router($this->getRouteCollectorStub(), $this->getRouteMatcherMock());
        $router->getRoute(["wrongType"]);
    }

    /**
     * @covers Brickoo\Routing\Router::hasRoute
     * @covers Brickoo\Routing\Router::getRoute
     */
    public function testHasRouteWithoutCollectionName() {
        $route = $this->getRouteStub();

        $routeCollection = $this->getRouteCollectionStub();
        $routeCollection->expects($this->any())
                        ->method("hasRoute")
                        ->will($this->onConsecutiveCalls(true, false));
        $routeCollection->expects($this->any())
                        ->method("getRoute")
                        ->will($this->returnValue($route));

        $router = new Router($this->getRouteCollectorStub($routeCollection), $this->getRouteMatcherMock());
        $this->assertTrue($router->hasRoute("unit.test.route"));
        $this->assertFalse($router->hasRoute("route.does.not.exist"));
    }

    /**
     * @covers Brickoo\Routing\Router::hasRoute
     * @covers Brickoo\Routing\Router::getRoute
     */
    public function testHasRouteWithCollectionName() {
        $collectionName = "unit-test-collection";

        $route = $this->getRouteStub();

        $routeCollection = $this->getRouteCollectionStub();
        $routeCollection->expects($this->any())
                        ->method("hasName")
                        ->will($this->returnValue(true));
        $routeCollection->expects($this->any())
                        ->method("getName")
                        ->will($this->returnValue($collectionName));
        $routeCollection->expects($this->any())
                        ->method("hasRoute")
                        ->will($this->onConsecutiveCalls(true, false));
        $routeCollection->expects($this->any())
                        ->method("getRoute")
                        ->with("unit.test.route")
                        ->will($this->returnValue($route));

        $router = new Router($this->getRouteCollectorStub($routeCollection), $this->getRouteMatcherMock());
        $this->assertTrue($router->hasRoute("unit.test.route", $collectionName));
        $this->assertFalse($router->hasRoute("route.does.not.exist", $collectionName));
    }

    /**
     * @covers Brickoo\Routing\Router::HasRoute
     * @expectedException InvalidArgumentException
     */
    public function testHasRouteThrowsInvalidArgumentException() {
        $router = new Router($this->getRouteCollectorStub(), $this->getRouteMatcherMock());
        $router->hasRoute(["wrongType"]);
    }

    /**
     * @covers Brickoo\Routing\Router::getExecutableRoute
     * @covers Brickoo\Routing\Router::getMatchingExecutableRoute
     * @covers Brickoo\Routing\Router::getMatchingRouteFromCollection
     */
    public function testGetExecutableRoute() {
        $route = $this->getRouteStub();

        $routeCollection = $this->getRouteCollectionStub();
        $routeCollection->expects($this->any())
                        ->method("hasPath")
                        ->will($this->returnValue(false));
        $routeCollection->expects($this->any())
                        ->method("getRoutes")
                        ->will($this->returnValue(array($route)));

        $router = new Router($this->getRouteCollectorStub($routeCollection), $this->getRouteMatcherMock($route));
        $this->assertInstanceOf("\\Brickoo\\Routing\\ExecutableRoute", ($executableRoute = $router->getExecutableRoute()));
        $this->assertSame($executableRoute, $router->getExecutableRoute());
    }

    /**
     * @covers Brickoo\Routing\Router::getExecutableRoute
     * @covers Brickoo\Routing\Router::getMatchingExecutableRoute
     * @covers Brickoo\Routing\Router::getMatchingRouteFromCollection
     * @covers Brickoo\Routing\Exception\NoMatchingRouteFoundException
     * @expectedException Brickoo\Routing\Exception\NoMatchingRouteFoundException
     */
    public function testGetExecutableThrowsNoMatchingRouteFoundException() {
        $routeCollection = $this->getRouteCollectionStub();
        $routeCollection->expects($this->any())
                        ->method("getRoutes")
                        ->will($this->returnValue(array()));

        $router = new Router($this->getRouteCollectorStub($routeCollection), $this->getRouteMatcherMock());
        $router->getExecutableRoute();
    }

    /**
     * Returns a route stub.
     * @return \Brickoo\Http\Route
     */
    private function getRouteStub() {
        return $this->getMockBuilder("\\Brickoo\\Routing\\Route")
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Returns a route collection sutb.
     * @return \Brickoo\Http\RouteCollection
     */
    private function getRouteCollectionStub() {
        return $this->getMockBuilder("\\Brickoo\\Routing\\RouteCollection")
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Stub creator for the route collector dependency.
     * @param \Brickoo\Routing\Route\RouteCollection $routeCollection
     * @return \Brickoo\Routing\RouteCollector
     */
    private function getRouteCollectorStub($routeCollection = null) {
        $routeCollector = $this->getMock("\\Brickoo\\Routing\\RouteCollector");
        $routeCollector->expects($this->any())
                       ->method("collect")
                       ->will($this->returnValue($routeCollector));
        $routeCollector->expects($this->any())
                       ->method("getIterator")
                       ->will($this->returnValue(new ArrayIterator(array($routeCollection))));
        return $routeCollector;
    }

    /**
     * Mock creator for the route matcher dependency.
     * @param \Brickoo\Routing\Route $route
     * @return Brickoo\Routing\RouteMatcher
     */
    private function getRouteMatcherMock($route = null) {
        $routeMatcher = $this->getMock("\\Brickoo\\Routing\\RouteMatcher");
        $routeMatcher->expects($this->any())
                     ->method("matchesCollection")
                     ->will($this->returnValue(true));
        $routeMatcher->expects($this->any())
                     ->method("matchesRoute")
                     ->with($route)
                     ->will($this->returnValue(true));
        $routeMatcher->expects($this->any())
                     ->method("getRouteParameters")
                     ->will($this->returnValue(array("key" => "value")));
        return $routeMatcher;
    }

}