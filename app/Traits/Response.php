<?php

namespace App\Traits;

trait Response
{
    public function success(int $status = 200 , string $message , object|array $data){
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ] , $status);
    }

    public function error(int $status = 500 , string $message){
        return response()->json([
            'status' => $status,
            'message' => $message
        ] , $status);
    }
}
