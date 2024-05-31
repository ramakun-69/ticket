<?php

namespace App\Http\Requests\Master;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class ShiftRequest extends FormRequest
{
    use FailedValidation;
    protected $fill = [
        'name' => 1,
        'id' => 0,
        'start_time' => 1,
        'end_time' => 1,
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
            $rule = ($this->fill[$key] == 1) ? 'required' : 'nullable';
            $dataValidate[$key] = $rule;
        }
        return $dataValidate;
    }
}
