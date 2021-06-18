<?php

namespace Core;

use Api\ApiStandard;

class Core extends ApiStandard
{      
    protected $token;

    function __construct()
    {
        $baseUrl          =     'https://api.bscscan.com/';
        $sslStatus        =     true;
        parent::__construct($baseUrl, $sslStatus);
    }

}