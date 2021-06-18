<?php

namespace Core;

use Api\ApiUrn;
use stdClass;

class Account extends CoreObject
{
    protected $id;
   
    // action
    // address
    // startblock
    // endblock
    // sort
    // apikey

    function __construct($id = 0)
    {
        parent::__construct();

        if(isset($id) && !empty($id))
        {
            $this->setId($id);
            $this->get();
        }
    }
    
    function getComments($parameters = [])
    {
        $request = new ApiUrn($this::OBJECT_SERVICE, $this->id, 'comments', $parameters);
        $albumComments = $this->communicate('', 'GET', $request);

        return $albumComments;
    }
}
