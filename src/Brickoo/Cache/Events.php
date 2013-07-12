<?php

    /*
     * Copyright (c) 2011-2013, Celestino Diaz <celestino.diaz@gmx.de>.
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

    namespace Brickoo\Cache;

    /**
     * Events
     *
     * Defines the cache events.
     * @author Celestino Diaz <celestino.diaz@gmx.de>
     */

    class Events {

        /**
         * Asks for a cached content.
         * @var string
         */
        const GET = 'brickoo.cache.get';

        /**
         * Notifies that the content to be cached.
         * @var string
         */
        const SET = 'brickoo.cache.set';

        /**
         * Asks for a cached content otherwise a callback should be executed.
         * @var string
         */
        const CALLBACK = 'brickoo.cache.callback';

        /**
         * Notifies that a specific cached content has to be deleted.
         * @var string
         */
        const DELETE = 'brickoo.cache.delete';

        /**
         * Notifies that all cached content has to be flushed.
         * @var string
         */
        const FLUSH = 'brickoo.cache.flush';

    }