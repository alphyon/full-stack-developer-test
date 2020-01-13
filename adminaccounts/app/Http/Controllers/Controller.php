<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\LogManger;
use App\Http\Controllers\Utils\ResponseUtils;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $NOT_FOUND = 'Not Found data';
    protected $response;
    protected $log;

    public function __construct()
    {

    }

    public function responseManage(){
        return new ResponseUtils();
    }

    public function logManager(){
        return new LogManger();
    }
}
