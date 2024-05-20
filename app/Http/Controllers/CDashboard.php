<?php

namespace App\Http\Controllers;

use App\Models\MAsset;
use App\Models\Ticket;
use App\Models\MPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CDashboard extends Controller
{
    public function index()
    {
        $title = __('Dashboard');
        $user = Auth::user()->pegawai;
        $role = Auth::user()->role;
        $tickets = Ticket::filterByRole($user, $role)->get();
        $onProcess = $tickets->where('status', 'process')->count();
        $closed = $tickets->where('status', 'closed')->count();
        $open = $tickets->where('status', 'waiting approval')->count();
        $total = $tickets->count();
        $productionAssets = MAsset::where("type", "produksi")->get();
        $itAssets = MAsset::where("type", "it")->get();
        $technician = MPegawai::whereHas('user', function ($query) {
            $query->where('role', 'teknisi');
        })->where('department_id', Auth::user()->pegawai?->department_id)->get();
        return view("pages.index", compact("title","onProcess","closed","open","total","productionAssets","itAssets","technician"));
    }
    public function notif(Request $request)
    {
        if ($request->id) {
            $notification = auth()->user()->unreadNotifications->where('id', decrypt($request->id))->first();
            if ($notification) {
                $notification->markAsRead();
            }
        }
        if ($notification->data['type']== 'comment') {
            return redirect($notification->data['url']);
        }else {
            return redirect()->route('ticket.index');
        }
    }   
    public function read(Request $request)
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    }
}
