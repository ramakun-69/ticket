<?php
namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Schema;

trait FailedValidation{
    use ResponseOutput;
    public function failedValidation(Validator $validator)
    {
        $errors = [];
        $errorMessages = $validator->errors()->messages();
        $keys = array_keys($this->fill);
        foreach ($keys as $key) {
            if(isset($errorMessages[$key])){
                $errors[$key] = collect($errorMessages[$key])->first();
            }
        }
        throw new HttpResponseException($this->responseErrorValidate($errors));
    }
}
