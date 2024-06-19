<?php

namespace App\Http\Controllers;

use App\Models\MAsset;
use App\Models\Ticket;
use App\Models\MMachine;
use App\Models\MPegawai;
use App\Models\MLocation;
use App\Models\MDepartment;
use Illuminate\Http\Request;
use App\Models\MProductionAsset;
use App\Models\MShift;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CDatatable extends Controller
{
    public function mLocation()
    {
        $data = MLocation::latest()->get();
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                return '    
                <div class="btn-group" role="group">
                    <a href="' . route('master-data.location.edit', $row) . '" class="btn btn-sm btn-warning edit me-2"><i class="mdi mdi-pencil"></i></a>
                    <a href="' . route('master-data.location.destroy', $row) . '" class="btn btn-sm btn-danger delete"><i class="mdi mdi-delete"></i></a>
                </div>';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
    public function mShift()
    {
        $data = MShift::all();
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                return '    
                <div class="btn-group" role="group">
                    <a href="' . route('master-data.shift.edit', $row) . '" class="btn btn-sm btn-warning edit me-2"><i class="mdi mdi-pencil"></i></a>
                    <a href="' . route('master-data.shift.destroy', $row) . '" class="btn btn-sm btn-danger delete"><i class="mdi mdi-delete"></i></a>
                </div>';
            })
            ->addColumn('time', function ($row) {
                $startTime = Carbon::parse($row->start_time)->format('H:i');
                $endTime = Carbon::parse($row->end_time)->format('H:i');
                return $startTime . ' - ' . $endTime;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
    public function mProductionAsset()
    {
        $data = MAsset::where('type', 'produksi')
            ->where('category', request('category'))->orderBy("created_at", "desc")->get();
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                return '    
                <div class="btn-group" role="group">
                    <a href="' . route('master-data.production-assets.edit', $row) . '" class="btn btn-sm btn-warning edit me-2"><i class="mdi mdi-pencil"></i></a>
                    <a href="' . route('master-data.production-assets.destroy', $row) . '" class="btn btn-sm btn-danger delete"><i class="mdi mdi-delete"></i></a>
                </div>';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
    public function mItAsset()
    {
        $data = MAsset::where('type', 'it')->orderBy("created_at", "desc")->get();
        return DataTables::of($data)
            ->addColumn('pic', function ($row) {
                return $row?->user?->pegawai?->name;
            })
            ->addColumn('action', function ($row) {
                return '    
                <div class="btn-group" role="group">
                    <a href="' . route('master-data.it-assets.edit', $row) . '" class="btn btn-sm btn-warning edit me-2"><i class="mdi mdi-pencil"></i></a>
                    <a href="' . route('master-data.it-assets.destroy', $row) . '" class="btn btn-sm btn-danger delete"><i class="mdi mdi-delete"></i></a>
                </div>';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
    public function mDepartment()
    {
        $data = MDepartment::latest()->get();
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                return '    
                <div class="btn-group" role="group">
                    <a href="' . route('master-data.production-assets.edit', $row) . '" class="btn btn-sm btn-warning edit me-2"><i class="mdi mdi-pencil"></i></a>
                    <a href="' . route('master-data.production-assets.destroy', $row) . '" class="btn btn-sm btn-danger delete"><i class="mdi mdi-delete"></i></a>
                </div>';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
    public function mPegawai()
    {
        $data = MPegawai::latest()->with(['user'])->get();
        return DataTables::of($data)
            ->addColumn('foto', function ($row) {
                return $row->user?->getPhoto();
            })
            ->addColumn('shift', function ($row) {
                return $row?->shift?->name;
            })
            ->addColumn('action', function ($row) {
                return '
                <div class="btn-group" role="group">
                    <a href="' . route('master-data.employee.edit', $row) . '" class="btn btn-sm btn-warning edit me-2"><i class="mdi mdi-pencil"></i></a>
                    <a href="' . route('master-data.employee.destroy', $row) . '" class="btn btn-sm btn-danger delete"><i class="mdi mdi-delete"></i></a>
                </div>';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
    public function ticket()
    {
        $user = Auth::user()->pegawai;
        switch (Auth::user()->role) {
            case 'staff':
                $data = Ticket::where('staff_id', $user->id)->where('status', '!=', 'closed')->latest()->get();
                break;
            case 'atasan':
                $data = Ticket::where('boss_id', $user->id)
                    ->where(function ($query) {
                        $query->where(function ($query) {
                            $query->when($query->whereNull('technician_boss_id'), function ($query) {
                                $query->where(function ($query) {
                                    $query->where('status', 'waiting approval');
                                });
                            });
                        });
                    })->get();
                break;
            case 'teknisi':
                $data = Ticket::whereHas('technician', function ($query) use ($user) {
                    $query->where('technician_id', $user->id);
                })
                    ->where(function ($query) {
                        $query->where('status', 'waiting process')
                            ->orWhere('status', 'process');
                    })
                    ->get();
                break;
            case 'atasan teknisi':
                $data = Ticket::where('technician_boss_id', $user->id)
                    ->where(function ($query) {
                        $query->where('status', 'waiting approval');
                    })
                    ->orWhere('status', 'closed')
                    ->get();
                break;
            case 'admin':
                $data = Ticket::where('status', '!=','closed')->latest();
                break;
            default:
                $data = [];
                break;
        }

        return DataTables::of($data)
            ->addColumn('status', function ($row) {
                return buildBadgeStatus($row->status);
            })
            ->addColumn('created_at', function ($row) {
                return toDateTimeIndo($row->created_at);
            })
            ->addColumn('action', function ($row) {
                return buildTicketActionHtml($row);
            })
            ->addColumn('type', function ($row) {
                return __($row->type);
            })
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->toJson();
    }
    public function myTicket()
    {
        $user = Auth::user()->pegawai;
        $data = Ticket::where("created_by", $user->id)->get();
        return DataTables::of($data)
            ->addColumn('status', function ($row) {
                return buildBadgeStatus($row->status);
            })
            ->addColumn('created_at', function ($row) {
                return toDateIndo($row->created_at);
            })
            ->addColumn('action', function ($row) {
                return buildTicketActionHtml($row);
            })
            ->addColumn('type', function ($row) {
                return __($row->type);
            })
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->toJson();
    }
    public function history()
    {
        $user = Auth::user()->pegawai;
        switch (Auth::user()->role) {
            case 'staff':
                $data = Ticket::where('staff_id', $user->id)->where('status', 'closed')->get();
                break;
            case 'atasan':
                $data = Ticket::where('boss_id', $user->id)
                    ->where('status', 'closed')
                    ->get();
                break;
            case 'teknisi':
                $data = Ticket::whereHas('technician', function ($query) use ($user) {
                    $query->where('technician_id', $user->id);
                })
                    ->where(function ($query) {
                        $query->where('status', 'closed');
                    })->get();
                break;
            case 'atasan teknisi':
                $data = Ticket::where('technician_boss_id', $user->id)->where('status', 'closed')
                    ->get();
                break;
            case 'admin':
                $data = Ticket::where('status', 'closed')->get();
                break;
            default:
                $data = [];
                break;
        }

        return DataTables::of($data)
            ->addColumn('status', function ($row) {
                return buildBadgeStatus($row->status);
            })
            ->addColumn('action', function ($row) {
                return buildTicketActionHtml($row);
            })
            ->addColumn('type', function ($row) {
                return __($row->type);
            })
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->toJson();
    }
}
