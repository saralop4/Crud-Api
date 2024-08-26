<?php

namespace App\Models\Response;

class ApiResponse {


    public static function ResponseSuccess($message= 'Exitoso',$statusCode= 200, $data=[]){

        return response()->json([
            'data'=>$data,
            'message' => $message,
            'statusCode' => $statusCode,
            'isSuccess'=>true]);
        }

    public static function ResponseError($message = 'Error', $statusCode, $data = [])
    {

        return response()->json([
            'data' => $data,
            'message' => $message,
            'statusCode' => $statusCode,
            'isSuccess' => false
        ]);
    }
 }
