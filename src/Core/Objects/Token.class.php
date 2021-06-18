<?php

namespace Core;

use Api\ApiUrn;
use stdClass;

class Token extends CoreObject
{
    const OBJECT_SERVICE = 'editorial';

    protected $id;

    function __construct($id = 0)
    {
        parent::__construct();

        if(isset($id) && !empty($id))
        {
            $this->setId($id);
            $this->get();
        }
    }

    function getSelection($parameters = [])
    {
        $request = new ApiUrn($this::OBJECT_SERVICE, 'id', 'selection', $parameters);
        $editorialSelection = $this->communicate('', 'GET', $request);

        return $editorialSelection;
    }

    function getCharts($parameters = [])
    {
        $request = new ApiUrn($this::OBJECT_SERVICE, 'id', 'charts', $parameters);
        $editorialCharts = $this->communicate('', 'GET', $request);

        return $editorialCharts;
    }

    function getReleases($parameters = [])
    {
        $request = new ApiUrn($this::OBJECT_SERVICE, 'id', 'releases', $parameters);
        $editorialReleases = $this->communicate('', 'GET', $request);

        return $editorialReleases;
    }




}
