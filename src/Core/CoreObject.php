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
            $this->get();
        }
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function get()
    {
        $parameters = [];
        
        if(isset($this->token) && !empty($this->token))
        {
            $parameters['access_token'] = $this->token;
        }

        $request = new ApiUrn($this::OBJECT_SERVICE, $this->id, '', $parameters);

        print_r($request->getUrn());

        $classInfo = $this->communicate('', 'GET', $request);
        $this->set($classInfo);

        return $classInfo;
    }

    private function set($classInfo)
    {
        foreach($classInfo as $attribute => $value)
        {
            $this->$attribute = $value;
        }
    }

}
