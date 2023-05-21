<?php 

namespace App\Traits;

trait HttpResponses{
    public function handleResponse( $result = null ,$msg = '',$status= 200){
        $res = [
            'success'=>true,
            'data'=>$result,
            'message'=>$msg
        ];
        return  response()->json($res, $status);
    }
    public function handleError($errors = [],$status){
        $res = [
            'success'=>false,
            'message'=>$errors
        ];
        return response()->json($res, $status);
    }
}