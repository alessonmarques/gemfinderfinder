<?php

namespace Core;

use Api\ApiUrn;
use stdClass;

class Account extends CoreObject
{
    /**
     * Define the BSC Module parameter.
     */
    const OBJECT_MODULE = 'account';

    protected $id;
    
    
    // apikey

    function __construct($id = 0)
    {
        parent::__construct();

        if(isset($id) && !empty($id))
        {
            $this->setId($id);
        }
    }
    
    function getTXList($custom_parameters = [   
                                                'startblock' => NULL, 
                                                'endblock' => NULL, 
                                                'sort' => 'desc'
                                            ])
    {
        $action = 'txlist';
        $parameters = [ 
            'address' => $this->id
        ];
        
        $this->getCustomParameters($parameters, $custom_parameters);    

        $request = new ApiUrn(
                                $this::OBJECT_SERVICE, 
                                $this::OBJECT_MODULE, 
                                $action, 
                                $parameters);

        $txList = $this->communicate('', 'GET', $request);
        return $txList;
    }
}
