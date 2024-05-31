<?php

namespace App\Http\Requests\Master;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class PegawaiRequest extends FormRequest
{
    use FailedValidation;
    protected $fill = [
        "id" => 0,
        "name" => 1,
        "address" => 1,
        "gender" => 1,
        "phone" => 1,
        "department_id" => 1,
        "user_id" => 0,
        "shift_id" => 1,
        "email" => 1,
        "username"=> 1,
        "position"=> 1,
        "role"=> 1,
    ];
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $dataValidate = [];
        foreach (array_keys($this->fill) as $key) {
            $dataValidate[$key] = ($this->fill[$key] == 1) ? 'required' : 'nullable';
            switch ($key) {
                case 'email':
                    $dataValidate[$key] = "unique:users,email,$this->user_id,id";
                    break;
                case 'username':
                    $dataValidate[$key] = "unique:users,username,$this->user_id,id";
                    break;
            }
        }
        return $dataValidate;
    }
}
