<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\LogManger;
use App\Http\Controllers\Utils\ResponseUtils;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $response;
    protected $log;
    protected $NOT_FOUND = 'Not Found data';

    public function __construct()
    {

    }

    function bcrypt($value, $options = [])
    {
        return app('hash')->make($value, $options);
    }



    public function responseManage(){
        return new ResponseUtils();
    }

    public function logManager(){
        return new LogManger();
    }
}
