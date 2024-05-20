<?php
namespace App\Traits;
use Illuminate\Support\Facades\DB;

trait ResponseOutput {
    function responseErrorValidate($validator){
        return response()->json([
            'status'=>false,
            'message'=>'Validation Failed!!',
            'data' => $validator
        ],422);
    }
    function safeApiCall(callable $callback) {

        try {
            return $callback();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseFailed($th->getMessage()."|".$th->getFile());
        }
    }
    function responseFailed($failedMsg){
        return response()->json([
            'status'=>false,
            'message'=>'Failed !!',
            'data' => [
                'error' => (config('app.debug')) ? $failedMsg : __("server_error")
            ]
        ],500);
    }
    function responseSuccess($data,$status = true){
        return response()->json([
            'status'=>$status,
            'message'=>'Success !!',
            'data' => $data
        ],200);
    }
}
