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
    
    function __construct($id = 0) {
    
        parent::__construct();

        if(isset($id) && !empty($id)) {
        
            $this->setId($id);
        }
    }
    
    function getNormalTXList($custom_parameters = [   
                                                'startblock' => NULL, 
                                                'endblock' => NULL, 
                                                'sort' => 'desc'
                                            ]) {
    
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

    function getInternalTXList($custom_parameters = [   
                                                'startblock' => NULL, 
                                                'endblock' => NULL, 
                                                'sort' => 'desc'
                                            ]) {
    
        $action = 'txlistinternal';
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

    function getInternalTX($txHash, $custom_parameters = []) {
    
        $action = 'txlistinternal';
        $parameters = [ 
            'txhash' => $txHash
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
