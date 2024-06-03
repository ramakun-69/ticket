<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    protected $with = ['asset', 'staff', 'department', 'boss','technicianBoss', 'sparepart', 'user'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($ticket) {
            $ticket->created_by = Auth::user()->pegawai->id;
        });
    }
    public function user()
    {
        return $this->belongsTo(MPegawai::class, 'created_by');
    }
    public function asset()
    {
        return $this->belongsTo(MAsset::class, 'asset_id');
    }

    public function staff()
    {
        return $this->belongsTo(MPegawai::class, 'staff_id');
    }

    public function department()
    {
        return $this->belongsTo(MDepartment::class, 'department_id');
    }
    public function technician()
    {
        return $this->hasMany(TechnicianTicket::class, 'ticket_id');
    }

    public function boss()
    {
        return $this->belongsTo(MPegawai::class, 'boss_id');
    }

    public function technicianBoss()
    {
        return $this->belongsTo(MPegawai::class, 'technician_boss_id');
    }
    public function sparepart()
    {
        return $this->hasMany(Sparepart::class, 'ticket_id');
    }
    public function scopeFilterByRole($query, $user, $role)
    {
        if ($role == 'admin') {
            return $query;
        }
        return $query->whereHas('technician',function ($query) use ($user, $role) {
            return $role == 'staff' ? $query->where('staff_id', $user->id) : ($role == 'atasan' ? $query->where('boss_id', $user->id) : ($role == 'teknisi' ? $query->where('technician_id', $user->id) : ($role == 'atasn teknisi' ? $query->where('technician_boss_id', $user->id) :
                null)));
        });
    }
    public function scopeFilteredReport($query, $user, $role, $data)
    {
        return $query->FilterByRole($user, $role)
            ->whereBetween('created_at', [$data['start_date'], Carbon::parse($data['end_date'])->addDay()])
            ->where('type', $data['type'])
            ->when(isset($data['category']), function ($query) use ($data) {
                $query->whereHas('asset', function ($query) use ($data) {
                    $query->where('category', $data['category']);
                });
            })->when(isset($data['asset_id']), function ($query) use ($data) {
                $query->where('asset_id', $data['asset_id']);
            })->where('status', "closed");
    }
}
