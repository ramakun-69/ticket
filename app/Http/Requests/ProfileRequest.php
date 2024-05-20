<?php

namespace App\Http\Requests;

use App\Traits\FailedValidation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    use FailedValidation;
    protected $fill = [
        'email' => 1,
        'password' => 0,
        'name' => 0,        
        'address' => 0,        
        'phone' => 0,                
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
        $id = Auth::user()->id;
        if (Auth::user()->role !='admin') {
            $this->fill["name"] = 1; 
            $this->fill["address"] = 1; 
            $this->fill["phone"] = 1; 
        }
        if (!$this->password) {
            unset($this->fill['password']);
        }
        $dataValidate = [];
        foreach (array_keys($this->fill) as $key) {
            $dataValidate[$key] = ($this->fill[$key] == 1) ? 'required' : 'nullable';
            switch ($key) {
                case 'email':
                    $dataValidate[$key] = "required|unique:users,email,$id,id";
                    break;
                case 'phone':
                    $dataValidate[$key] .= "|unique:m_pegawais,phone,$id,user_id";
                    break;
                
            }

        }
        return $dataValidate;
    }
}
