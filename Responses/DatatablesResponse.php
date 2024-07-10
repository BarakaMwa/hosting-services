<?php

namespace Responses;

class DatatablesResponse
{

    /**
     * @var int|void
     */
    public $recordsTotal;
    /**
     * @var int|void
     */
    public $recordsFiltered;
    /**
     * @var mixed
     */
    public $draw;
    public $data;

    public function __construct()
    {

    }

}