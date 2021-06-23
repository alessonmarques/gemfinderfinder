<?php

namespace Core;

use Api\ApiUrn;
class Token extends CoreObject
{
    /**
     * Define the BSC Module parameter.
     */
    const OBJECT_SERVICE    = 'api';
    const OBJECT_MODULE     = 'token';

    protected $id;
    
    function __construct($id = 0) {
    
        parent::__construct();

        if(isset($id) && !empty($id)) {
        
            $this->setId($id);
        }
    }

}
