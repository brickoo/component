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

namespace Brickoo\Component\Cache\Adapter;

use Brickoo\Component\Cache\Adapter\Exception\PoolIdentifierDoesNotExistException,
    Brickoo\Component\Cache\Adapter\Exception\PoolIsEmptyException,
    Brickoo\Component\Validation\Constraint\ContainsInstancesOfConstraint,
    Brickoo\Component\Validation\Argument;

/**
 * AdapterPoolIterator
 *
 * Implementation of an iterable caching adapter pool.
 * @author Celestino Diaz <celestino.diaz@gmx.de>
 */
class AdapterPoolIterator implements \Iterator, \Countable, AdapterPool {

    /** @var array containing entries of type \Brickoo\Component\Cache\Adapter\Adapter */
    private $poolEntries;

    /** @var array */
    private $mappingKeys;

    /** @var integer */
    private $currentPointerPosition;

    /**
     * Class constructor.
     * @param array $poolEntries
     * @throws \InvalidArgumentException if a pool entry does not match expected type
     */
    public function __construct(array $poolEntries) {
        if (! (new ContainsInstancesOfConstraint("\\Brickoo\\Component\\Cache\\Adapter\\Adapter"))->matches($poolEntries)) {
            throw new \InvalidArgumentException(sprintf(
                "%s: The pool entries must be instances implementing \\Brickoo\\Component\\Cache\\Adapter\\Adapter interface.",
                __CLASS__
            ));
        }

        $this->poolEntries = array_values($poolEntries);
        $this->mappingKeys = array_keys($poolEntries);
        $this->currentPointerPosition = 0;
    }

     /**
     * Checks if the current pool adapter entry is ready.
     * @throws \Brickoo\Component\Cache\Adapter\Exception\PoolIsEmptyException
     * @return boolean check result
     */
    public function isCurrentReady() {
        return $this->current()->isReady();
    }

    /**
     * {@inheritDoc}
     * @throws \Brickoo\Component\Cache\Adapter\Exception\PoolIsEmptyException
     * @return \Brickoo\Component\Cache\Adapter\Adapter
     */
    public function current() {
        if ($this->isEmpty() || (!isset($this->poolEntries[$this->currentPointerPosition]))) {
            throw new PoolIsEmptyException();
        }
        return $this->poolEntries[$this->currentPointerPosition];
    }

    /**
     * {@inheritDoc}
     * @return string the current pool key
     */
    public function key() {
        if (isset($this->mappingKeys[$this->currentPointerPosition])) {
            return $this->mappingKeys[$this->currentPointerPosition];
        }
        return (string)$this->currentPointerPosition;
    }

    /** {@inheritDoc} */
    public function next() {
        $this->currentPointerPosition++;
    }

    /** {@inheritDoc} */
    public function rewind() {
        $this->currentPointerPosition = 0;
    }

    /** {@inheritDoc} */
    public function valid() {
        return isset($this->poolEntries[$this->currentPointerPosition]);
    }

    /** {@inheritDoc} */
    public function select($adapterIdentifier) {
        Argument::IsStringOrInteger($adapterIdentifier);

        if (! $this->has($adapterIdentifier)) {
            throw new PoolIdentifierDoesNotExistException($adapterIdentifier);
        }

        $this->currentPointerPosition = $this->getMappingPosition($adapterIdentifier);
        return $this;
    }

    /** {@inheritDoc} */
    public function remove($adapterIdentifier) {
        if (! $this->has($adapterIdentifier)) {
            throw new PoolIdentifierDoesNotExistException($adapterIdentifier);
        }

        $mappingPosition = $this->getMappingPosition($adapterIdentifier);
        unset($this->poolEntries[$mappingPosition]);
        unset($this->mappingKeys[$mappingPosition]);

        $this->poolEntries = array_values($this->poolEntries);
        $this->mappingKeys = array_values($this->mappingKeys);

        if ($this->currentPointerPosition > 0 && $this->currentPointerPosition >= $mappingPosition) {
            --$this->currentPointerPosition;
        }

        return $this;
    }

    /** {@inheritDoc} */
    public function has($adapterIdentifier) {
        Argument::IsStringOrInteger($adapterIdentifier);
        return in_array($adapterIdentifier, $this->mappingKeys, true);
    }

    /** {@inheritDoc} */
    public function isEmpty() {
        return empty($this->poolEntries);
    }

    /** {@inheritDoc} */
    public function count() {
        return count($this->poolEntries);
    }

    /**
     * Returns the position inside the adapter pool.
     * @param string|integer $adapterIdentifier
     * @return integer the position
     */
    private function getMappingPosition($adapterIdentifier) {
        return array_search($adapterIdentifier, $this->mappingKeys, true);
    }

}