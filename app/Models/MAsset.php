<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MAsset extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    protected $with =["location","user"];
    public function location()
    {
        return $this->belongsTo(MLocation::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
