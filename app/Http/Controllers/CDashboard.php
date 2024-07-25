<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MAsset;
use App\Models\Ticket;
use App\Models\MPegawai;
use Illuminate\Http\Request;
use App\Charts\DowntimeChart;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CDashboard extends Controller
{
    public function index(DowntimeChart $chart, Request $request)
    {
        $title = __('Dashboard');
        $user = Auth::user()->pegawai;
        $role = Auth::user()->role;
        $tickets = Ticket::filterByRole($user, $role)->get();
        $chart = $chart->build($request);
        $monthlyTicket = Ticket::getMonthlyTicket($request->start_date, $request->end_date, Auth::user(), $request->asset_id)
            ->get()
            ->groupBy('asset_id')
            ->map(function ($tickets) {
                $downtime = $tickets->sum(function ($ticket) {
                    $start = Carbon::parse($ticket->start_time);
                    $finish = Carbon::parse($ticket->finish_time);
                    return $finish->diffInMinutes($start);
                });
                return [
                    'asset_name' => $tickets->first()->asset->name,
                    'service_count' => $tickets->count() . " Kali",
                    'downtime' => "$downtime Menit"
                ];
            });
       
        return view("pages.index", compact("title", "tickets", "chart", "monthlyTicket"));
    }
    public function print(Request $request)
    {
        $title = __('Dashboard');
        $user = Auth::user()->pegawai;
        $role = Auth::user()->role;
        $tickets = Ticket::filterByRole($user, $role)->get();
        $monthlyTicket = Ticket::getMonthlyTicket($request->start_date, $request->end_date, Auth::user(), $request->asset_id)
            ->get()
            ->groupBy('asset_id')
            ->map(function ($tickets) {
                $downtime = $tickets->sum(function ($ticket) {
                    $start = Carbon::parse($ticket->start_time);
                    $finish = Carbon::parse($ticket->finish_time);
                    return $finish->diffInMinutes($start);
                });
                return [
                    'asset_name' => $tickets->first()->asset->name,
                    'service_count' => $tickets->count() ,
                    'downtime' => $downtime
                ];
            });
       
            $pdf = Pdf::loadView('pages.print', ['monthlyTicket' => $monthlyTicket]);
            return $pdf->stream();
    }
    public function notif(Request $request)
    {
        if ($request->id) {
            $notification = auth()->user()->unreadNotifications->where('id', decrypt($request->id))->first();
            if ($notification) {
                $notification->markAsRead();
            }
        }
        if ($notification->data['type'] == 'comment') {
            return redirect($notification->data['url']);
        } else {
            return redirect()->route('ticket.index');
        }
    }
    public function read(Request $request)
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    }
}
