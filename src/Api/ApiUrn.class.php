<?php

    namespace Api;

    class ApiUrn
    {
        private $service;
        private $action;
        private $module;
        private $parameters;

        private $path;

        function __construct($service = '', $module = '', $action = '', $parameters = []) {
        
            $this->service      =   $service;
            $this->action       =   $action;
            $this->module       =   $module;
            $this->parameters   =   $this->constructParameterQueryString($parameters);

            $this->constructPath();
        }

        public function setService($service) {
        
            $this->service      =   $service;
            $this->constructPath();
        }

        public function setAction($module) {
        
            $this->module      =   $module;
            $this->constructPath();
        }

        public function setModule($action) {
        
            $this->action      =   $action;
            $this->constructPath();
        }
        
        public function setParameters($parameters) {
        
            $this->parameters   =   $this->constructParameterQueryString($parameters);
            $this->constructPath();
        }

        public function getUrn() {
        
            return $this->path;
        }

        private function constructParameterQueryString($parameters) {
        
            $queryString = [
                "module={$this->module}",
                "action={$this->action}"
            ];

            foreach($parameters as $parameterName => $parameterValue) {
            
                $queryString[] = "{$parameterName}={$parameterValue}";
            }
            $queryString = implode('&', $queryString);
            $queryString = "?{$queryString}";

            return $queryString;
        }

        private function constructPath() {
        
            $this->path         =   implode('/', [$this->service, $this->parameters]);
        }

    }
