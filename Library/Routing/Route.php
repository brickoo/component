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

    namespace Brickoo\Library\Routing;

    use Brickoo\Library\Routing\Interfaces;
    use Brickoo\Library\Validator\TypeValidator;

    /**
     * Route
     *
     * Implents a Route which can be configured to handle requests
     * which execute the assigned controller and action.
     * The regular espressions properties should not contain the delimiters or
     * the `^` on the beginning nor the `$` at the end of the expression.
     * The delimter used later for the regular expressions is `~`.
     * @author Celestino Diaz <celestino.diaz@gmx.de>
     */

    class Route implements Interfaces\RouteInterface
    {

        /**
         * Holds the route path listening to.
         * @var string
         */
        protected $path;

        /**
         * Returns the route path listening to.
         * @throws UnexpectedValueException if the path is null
         * @return string the route path listening to
         */
        public function getPath()
        {
            if ($this->path === null) {
                throw new \UnexpectedValueException('The route path is `null`.');
            }

            return $this->path;
        }

        /**
         * Sets the route path to listen to.
         * @param string $path the path to liste to
         * @return \Brickoo\Library\Routing\Route
         */
        public function setPath($path)
        {
            TypeValidator::IsString($path);

            $this->path = $path;

            return $this;
        }

        /**
         * Holds the controller:method which should be executed.
         * @var string
         */
        protected $controller;

        /**
         * Returns the controller:method to execute.
         * @throws UnexpectedValueException if the controller is null
         * @return string the controller and method to execute
         */
        public function getController()
        {
            if ($this->controller === null) {
                throw new \UnexpectedValueException('The route controller is `null`.');
            }

            return $this->controller;
        }

        /**
         * Sets the controller:method to execute.
         * The controller and method has to be seperated by '::'.
         * @param string $controller the controller and method to execute
         * @return \Brickoo\Library\Routing\Route
         */
        public function setController($controller)
        {
            TypeValidator::MatchesRegex('~^\\\\[\w\\\\]+\:\:[\w]+$~', $controller);

            $this->controller = $controller;

            return $this;
        }

        /**
         * Holds the request method to listen to.
         * @var string
         */
        protected $method;

        /**
         * Returns the listening request method.
         * If the route is only available for cli requests is must be set to LOCAL.
         * @throws UnexpectedValueException if the method is null
         * @return string the request method listening
         */
        public function getMethod()
        {
            if ($this->method === null) {
                throw new \UnexpectedValueException('The route method is `null`.');
            }

            return $this->method;
        }

        /**
         * Sets the request method to listen to.
         * The method could be a regular expression like GET|POST.
         * @param string $method the request method to listen
         * @return \Brickoo\Library\Routing\Route
         */
        public function setMethod($method)
        {
            TypeValidator::IsString($method);

            $this->method = $method;

            return $this;
        }

        /**
         * Holds the hostname to listen to.
         * to allow domains and subdomains.
         * @var string
         */
        protected $hostname;

        /**
         * Returns the hostname listening to.
         * @return string if the hostname is set otherwise null
         */
        public function getHostname()
        {
            return $this->hostname;
        }

        /**
         * Sets the request method to listen to.
         * The hostname could be a regular expression like ([a-z]+\.)?domain\.com
         * @param string $method the request method to listen
         * @return \Brickoo\Library\Routing\Route
         */
        public function setHostname($hostname)
        {
            TypeValidator::IsString($hostname);

            $this->hostname = $hostname;

            return $this;
        }

        /**
         * Holds the flag to enable session usage.
         * @var boolean
         */
        protected $sessionEnabled;

        /**
         * Checks if the session should be available.
         * @return boolean check result
         */
        public function isSessionEnabled()
        {
            return $this->sessionEnabled;
        }

        /**
         * Enables or the session usage.
         * @return \Brickoo\Library\Routing\Route
         */
        public function enableSession()
        {
            $this->sessionEnabled = true;

            return $this;
        }

        /**
         * Holds the session configuration to set.
         * @var array
         */
        protected $sessionConfiguration;

        /**
         * Returns the session configuration to use.
         * @return array the session configuration to use
         */
        public function getSessionConfiguration()
        {
            return $this->sessionConfiguration;
        }

        /**
         * Sets the session configuration to use.
         * The array keys which have effect are:
         * - id for session_id()
         * - name  for session_name()
         * - limiter for session_set_limiter()
         * @param array $configuration the session configuration
         * @return \Brickoo\Library\Routing\Route
         */
        public function setSessionConfiguration(array $configuration)
        {
            $this->sessionConfiguration = $configuration;

            return $this;
        }

        /**
         * Holds the flag to cache the reponse.
         * @var boolean
         */
        protected $cacheable;

        /**
         * Checks if the response is cacheable.
         * @return boolean check result
         */
        public function isCacheable()
        {
            return $this->cacheable;
        }

        /**
         * Enables or disables the response cache.
         * @return \Brickoo\Library\Routing\Route
         */
        public function enableCache()
        {
            $this->cacheable = true;

            return $this;
        }

        /**
         * Holds the response cache lifetime in seconds.
         * @var integer
         */
        protected $cacheLifetime;

        /**
         * Returns the response cache lifetime.
         * @return the response cache lifetime in seconds
         */
        public function getCacheLifetime()
        {
            return $this->cacheLifetime;
        }

        /**
         * Sets the response cache lifetime in seconds
         * @param integer $lifetime the response cache lifetime
         * @return \Brickoo\Library\Routing\Route
         */
        public function setCacheLifetime($lifetime)
        {
            TypeValidator::IsInteger($lifetime);

            $this->cacheLifetime = $lifetime;

            return $this;
        }

        /**
         * Holds the default key-values for the method parameters.
         * @var array
         */
        protected $defaultValues;

        /**
         * Returns all the default values available.
         * @return array the default key-values if any
         */
        public function getDefaultValues()
        {
            return $this->defaultValues;
        }

        /**
         * Returns the default value of the passed parameter name.
         * @param string $parameterName the parameter name
         * @throws UnexpectedValueException if the parameter has not an default value
         * @return mixed the default value for the passed parameter name
         */
        public function getDefaultValue($parameterName)
        {
            TypeValidator::IsString($parameterName);

            if (! $this->hasDefaultValue($parameterName)) {
                throw new \UnexpectedValueException(
                    sprintf('The default value for `%s`does not exist.', $parameterName)
                );
            }

            return $this->defaultValues[$parameterName];
        }

        /**
         * Checks if the parameter has an default value.
         * @param string $parameterName the parameter to check
         * @return boolean check result
         */
        public function hasDefaultValue($parameterName)
        {
            TypeValidator::IsString($parameterName);

            return array_key_exists($parameterName, $this->defaultValues);
        }

        /**
         * Adds an parameter and his default value.
         * If the parameter name does exists it will be overwritten !
         * @param string $parameterName the parameter name to add the value to
         * @param mixed $defaultValue the default value to add
         * @return \Brickoo\Library\Routing\Route
         */
        public function addDefaultValue($parameterName, $defaultValue)
        {
            TypeValidator::IsString($parameterName);

            $this->defaultValues[$parameterName] = $defaultValue;

            return $this;
        }

        /**
         * Holds the rules for the path parameters.
         * @var array
         */
        protected $rules;

        /**
         * Returns all the regular expression rules available.
         * @return array the regular expression rules if any
         */
        public function getRules()
        {
            return $this->rules;
        }

        /**
         * Returns the regular expression rule for the passed parameter name.
         * @param string $parameterName the parameter name to retrieve the rule for
         * @throws UnexpectedValueException if the parameter name has not an defualt value
         * @return string the rule assigned to the parameter name
         */
        public function getRule($parameterName)
        {
            TypeValidator::IsString($parameterName);

            if (! $this->hasRule($parameterName)) {
                throw new \UnexpectedValueException(
                    sprintf('The rule for `%s` does not exits.', $parameterName)
                );
            }

            return $this->rules[$parameterName];
        }

        /**
         * Adds a regular expression rule to a parameter name.
         * @param string $parameterName the parameter name to add the rule to
         * @param string $rule the rule to add
         * @return \Brickoo\Library\Routing\Route
         */
        public function addRule($parameterName, $rule)
        {
            TypeValidator::IsString($parameterName);
            TypeValidator::isString($rule);

            $this->rules[$parameterName] = $rule;

            return $this;
        }

        /**
         * Checks if the parameter has a rule to match.
         * @param string $parameterName the parameter name to check
         * @return boolean check result
         */
        public function hasRule($parameterName)
        {
            TypeValidator::IsString($parameterName);

            return array_key_exists($parameterName, $this->rules);
        }

        /**
        * Class constructor.
        * Initializes the class properties.
        * @return void
        */
        public function __construct()
        {
            $this->controller              = null;
            $this->path                    = null;
            $this->method                  = null;
            $this->hostname                = null;
            $this->sessionEnabled          = false;
            $this->sessionConfiguration    = array();
            $this->defaultValues           = array();
            $this->rules                   = array();
            $this->cacheable               = false;
            $this->cacheLifetime           = 60;
        }

    }