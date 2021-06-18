<?php

    namespace Api;

    class ApiUrn
    {
        private $service;
        private $parameters;

        private $path;

        function __construct($service = '', $parameters = [])
        {
            $this->service      =   $service;
            $this->parameters   =   $this->constructParameterQueryString($parameters);

            $this->constructPath();
        }

        public function setService($service)
        {
            $this->service      =   $service;
            $this->constructPath();
        }

        public function setParameters($parameters)
        {
            $this->parameters   =   $this->constructParameterQueryString($parameters);
            $this->constructPath();
        }

        public function getUrn()
        {
            return $this->path;
        }

        private function constructParameterQueryString($parameters)
        {
            $queryString = [];

            foreach($parameters as $parameterName => $parameterValue)
            {
                $queryString[] = "{$parameterName}={$parameterValue}";
            }
            $queryString = implode('&', $queryString);
            $queryString = "?{$queryString}";

            return $queryString;
        }

        private function constructPath()
        {
            $this->path         =   implode('/', [$this->service, $this->parameters]);
        }

    }
