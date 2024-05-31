<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MPegawai extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    protected $with =["department", "shift"];
    
    public function department()
    {
        return $this->belongsTo(MDepartment::class, "department_id");
    }
    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }
    public function shift()
    {
        return $this->belongsTo(MShift::class,"shift_id") ?? null;
    }
}
