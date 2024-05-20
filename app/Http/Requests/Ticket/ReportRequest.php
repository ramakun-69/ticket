<?php

namespace App\Http\Requests\Ticket;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    use FailedValidation;
    protected $fill = [
        'start_date' => 1,
        'end_date' => 1,
        'category' => 0,
        'type' => 1,
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
        }
        return $dataValidate;
    }
}
