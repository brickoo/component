<?php

    /*
     * Copyright (c) 2011-2012, Celestino Diaz <celestino.diaz@gmx.de>.
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
     * 3. Neither the name of Brickoo nor the names of its contributors may be used
     *    to endorse or promote products derived from this software without specific
     *    prior written permission.
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

    use Brickoo\Cache\Provider\NullProvider;

    // require PHPUnit Autoloader
    require_once ('PHPUnit/Autoload.php');

    /**
     * NullProviderTest
     *
     * Test suite for the NullProvider class.
     * Some of the test cases are using the PHP temporary directory for the cache files.
     * @see Brickoo\Cache\Provider\FileProvider
     * @author Celestino Diaz <celestino.diaz@gmx.de>
     */

    class NullProviderTest extends \PHPUnit_Framework_TestCase {

        /**
         * Holds an instance of the NullProvider class.
         * @var NullProvider
         */
        protected $NullProvider;

        /**
         * Set up the NullProvider object used.
         * @return void
         */
        protected function setUp() {
            $this->NullProvider = new NullProvider();
        }

        /**
         * Test if the NullProvider returns always false.
         * @covers Brickoo\Cache\Provider\NullProvider::get
         */
        public function testGet() {
            $this->assertFalse($this->NullProvider->get('whatever'));
        }

        /**
         * Test if the NullProvider returns always true.
         * @covers Brickoo\Cache\Provider\NullProvider::set
         */
        public function testSet() {
            $this->assertTrue($this->NullProvider->set('whatever', 'non cached content', 60));
        }

        /**
         * Test if the NullProvider returns always true.
         * @covers Brickoo\Cache\Provider\NullProvider::delete
         */
        public function testDelete() {
            $this->assertTrue($this->NullProvider->delete('whatever'));
        }

        /**
         * Test if the NullProvider returns always true.
         * @covers Brickoo\Cache\Provider\NullProvider::flush
         */
        public function testFlush() {
            $this->assertTrue($this->NullProvider->flush());
        }

    }
