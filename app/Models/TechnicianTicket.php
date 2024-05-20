<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicianTicket extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    protected $with = ["technician"];
    public $timestamps = true;

    public function ticket()
    {
        return $this->hasOne(Ticket::class, 'ticket_id');
    }
    public function technician()
    {
        return $this->belongsTo(MPegawai::class, 'technician_id');
    }
}
