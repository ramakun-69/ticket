<?php

namespace App\Http\Controllers\Ticket;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Exports\Report;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Ticket\ReportRequest;

class CReport extends Controller
{
    public function index()
    {
        $title = __("Report");
        return view("pages.ticket.report", compact("title"));
    }

    public function store(ReportRequest $request)
    {
        // dd($request);

        $data = $request->validated();
        $user = Auth::user()->pegawai;
        $role = Auth::user()->role;
        $report = Ticket::filteredReport($user, $role, $data)->get();
        return DataTables::of($report)
            ->addColumn('status', function ($row) {
                return buildBadgeStatus($row->status);
            })
            ->addColumn('type', function ($row) {
                return __($row->type);
            })
            ->addIndexColumn()
            ->rawColumns(['status'])
            ->toJson();
    }

    public function export(ReportRequest $request)
    {
        $data = $request->validated();
        return Excel::download(new Report($data), 'report.xlsx');
    }
}
