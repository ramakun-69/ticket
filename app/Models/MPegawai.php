<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MPegawai extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    protected $with =["department"];
    
    public function department()
    {
        return $this->belongsTo(MDepartment::class, "department_id");
    }
    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }
}
