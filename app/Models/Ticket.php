<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    protected $with = ['asset', 'staff', 'department', 'boss', 'technicianBoss', 'sparepart', 'user'];

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

    public function scopeFilterByRole(Builder $query, $user, $role)
    {
        $roleRelations = [
            'staff' => ['staff', 'staff_id'],
            'atasan' => ['boss', 'boss_id'],
            'teknisi' => ['technician', 'technician_id'],
            'atasan teknisi' => ['technicianBoss', 'technician_boss_id'],
        ];

        if ($role == 'admin') {
            return $query;
        }

        if (isset($roleRelations[$role])) {
            $relation = $roleRelations[$role];
            return $query->whereHas($relation[0], function ($query) use ($user, $relation) {
                $query->where($relation[1], $user->id);
            });
        }

        // Handle other roles if necessary
        return $query;
    }

    public function scopeGetMonthlyDowntime($query, $startDate = null, $endDate = null, $user, $assetId)
    {  
        return $query->FilterByRole($user->pegawai, $user->role)
            ->when(isset($startDate) && isset($endDate), function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->when($assetId, function ($query) use ($assetId) {
                $query->where('asset_id', $assetId);
            })
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', 'closed')
            ->get()
            ->groupBy(function ($ticket) {
                return Carbon::parse($ticket->created_at)->format('m');
            })
            ->map(function ($tickets) {
                return $tickets->sum(function ($ticket) {
                    // Pastikan bahwa start_time dan finish_time dalam format waktu yang benar
                    $start = Carbon::parse($ticket->start_time);
                    $finish = Carbon::parse($ticket->finish_time);
                    // Hitung selisih waktu dalam menit
                    return $finish->diffInMinutes($start);
                });
            });
    }
    public function scopeGetMonthlyTicket($query, $startDate = null, $endDate = null, $user, $assetId)
    {   
        return $query->FilterByRole($user->pegawai, $user->role)
            ->when(isset($startDate) && isset($endDate), function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->when($assetId, function ($query) use ($assetId) {
                $query->where('asset_id', $assetId);
            })
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', 'closed');
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
