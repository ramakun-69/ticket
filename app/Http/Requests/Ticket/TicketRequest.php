<?php

namespace App\Http\Requests\Ticket;

use App\Traits\FailedValidation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    use FailedValidation;
    protected $fill = [
        "asset_id" => 1,
        "condition" => 1,
        "description" => 1,
        "damage_time" => 1,
        "type" => 1,
        "part_name" => 0,
        "total" => 0,
        "unit" => 0,
        "information" => 0,
        "status_ticket" => 0,
        "technician_id" => 0,
        // "problem_analysis" => 0,
        "action" => 0,
        "id" => 0
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
        if ($this->id) {
            unset($this->fill['asset_id'], $this->fill['condition'], $this->fill['description'], $this->fill['type'], $this->fill['damage_time']);
        }
        if (Auth::user()->role == "atasan" && $this->id) {
            $this->fill['ticket_status'] = 1;
        } elseif (Auth::user()->role == "atasan teknisi" && $this->id) {
            $this->fill['ticket_status'] = 1;
            if ($this->ticket_status != "rejected") {
                $this->fill['technician_id'] = 1;
            }
        } elseif (Auth::user()->role == "teknisi" && $this->id) {
            $this->fill["action"] = 1;
        }
        foreach (array_keys($this->fill) as $key) {
            $dataValidate[$key] = ($this->fill[$key] == 1) ? 'required' : 'nullable';
        }
        return $dataValidate;
    }
}
