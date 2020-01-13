<?php


namespace App\Http\Controllers\Utils;


class ResponseUtils
{
    public function response($message,$data,$status,$error){
        return response()->json(
            [
                'message'=>$message,
                'data'=>$data,
                'error'=>$error,
                'status'=>$status
            ],$status);
    }

}
