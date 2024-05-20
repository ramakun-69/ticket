<?php

namespace App\Http\Requests\Master;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class AssetRequest extends FormRequest
{ 
    use FailedValidation;
    /**
     * Determine if the user is authorized to make this request.
     */
    protected $fill = [
        'name' => 1,
        'code' => 1,
        'category' => 1,
        'location_id' => 0,
        'user_id' => 0,
        'id' => 0
    ];
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
        if ($this->type == "produksi") {
            $this->fill['location_id'] = 1;
        }elseif ($this->type == "it") {
            if ($this->category != 'service') {
                $this->fill['user_id'] = 1;
            }
        }
        $dataValidate = [];
        foreach (array_keys($this->fill) as $key) {
            $dataValidate[$key] = ($this->fill[$key] == 1) ? 'required' : 'nullable';
        }
        return $dataValidate;
    }
}
