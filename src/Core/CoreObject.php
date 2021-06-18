<?php

namespace Core;

use Api\ApiUrn;

class CoreObject extends Core
{
    const OBJECT_SERVICE = 'api';

    public $tokenDestroyTime;

    function __construct($id = 0)
    {
        parent::__construct();

        if(isset($id) && !empty($id))
        {
            $this->setId($id);
        }
    }

    function setId($id)
    {
        $this->id = $id;
    }

    private function set($classInfo)
    {
        foreach($classInfo as $attribute => $value)
        {
            $this->$attribute = $value;
        }
    }

    function getCustomParameters(&$parameters, $custom_parameters) 
    {
        foreach ($custom_parameters as $name => $value) 
        {
            if(isset($value) && !is_null($value))
            {
                $parameters[$name] = $value;
            }
        }

        $parameters['apikey'] = $this->token;
    }

}
