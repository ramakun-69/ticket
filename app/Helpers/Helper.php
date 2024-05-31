<?php

use Carbon\Carbon;
use App\Models\MShift;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


function generateTicketNumber($type)
{
    // Tentukan kode berdasarkan tipe tiket
    $code = ($type == 'machine') ? "TM" : (($type == 'utilities') ? "TU" : (($type == 'sipil') ? "TS" : "IT"));

    $currentMonth = date('m');
    $currentYear = date('Y');
    $lastTicketNumber = DB::table('tickets')
        ->whereMonth('created_at', '=', $currentMonth)
        ->whereYear('created_at', '=', $currentYear)
        ->max('ticket_number');

    if (!$lastTicketNumber) {
        $ticketNumber = 'WO-' . $code . '-001';
    } else {
        $lastTicketNumber = explode('-', $lastTicketNumber)[2];
        $lastTicketNumber = (int)$lastTicketNumber;
        $lastTicketNumber++;
        $lastTicketNumber = str_pad($lastTicketNumber, 3, '0', STR_PAD_LEFT);
        $ticketNumber = 'WO-' . $code . '-' . $lastTicketNumber;
    }

    return $ticketNumber;
}

function setShift()
{
    $currentTime = Carbon::now();
    $shifts = MShift::all();
    foreach ($shifts as $shift) {
        $startTime = Carbon::parse($shift->start_time);
        $endTime = Carbon::parse($shift->end_time);
        if ($currentTime->between($startTime, $endTime)) {
            Session::put('shift', $shift->name);
            return;
        }
    }
    Session::put('shift', null);
}

function buildBadgeStatus($text)
{
    $result = "";
    switch ($text) {
        case "waiting approval":
            $result = "bg-warning";
            break;
        case "rejected":
            $result = "bg-danger";
            break;
        case "process":
            $result = "bg-warning";
            break;
        case "waiting validation":
            $result = "bg-warning";
            break;
        case "waiting process":
            $result = "bg-warning";
            break;
        case "waiting closed":
            $result = "bg-warning";
            break;
        case "closed":
            $result = "bg-success";
            break;
    }
    return "<span class='badge $result rounded-pill'>" . __($text) . "</span>";
}

function buildTicketActionHtml($row)
{
    $userRole = Auth::user()->role;
    $technicianTicket = $row->technician->where('technician_id', Auth::user()?->pegawai?->id)->first();
    $actionHtml = '<div class="btn-group" role="group">';

    //Edit
    if ($userRole != "staff" && $userRole != "admin" && $userRole != "teknisi" &&  ($row->status != 'closed' && $row->status != 'rejected' && $row->status != 'waiting closed')) {
        $editAction = '<a href="' . route('ticket.edit', $row) . '" class="badge bg-warning edit me-2"><i class="mdi mdi-pencil" style="font-size:15px;"></i></a>';
    } elseif ($userRole == "teknisi") {
        if ($row->status == "waiting process" &&  $technicianTicket->status == 0) {
            $editAction = '<a href="' . route('ticket.confirm', $row) . '" class="btn btn-primary btn-sm confirm me-2" data-id="' . $row->id . '">' . __("Confirm") . '</a>';
        } elseif ($row->status == "process") {
            $editAction = '<a href="' . route('ticket.edit', $row) . '" class="btn btn-success btn-sm  edit me-2">' . __('Finish') . '</a>';
        }
    } elseif ($userRole == 'atasan') {
        if ($row->status == "waiting closed") {
            $editAction = '<a href="' . route('ticket.close', $row) . '" class="btn btn-danger btn-sm close me-2" data-id="' . $row->id . '">' . __("Close Ticket") . '</a>';
        }
    }
    //Delete
    // if ($userRole == "admin" && $row->status == "closed") {
    //     $deleteAction = '<a href="' . route('ticket.destroy', $row->id) . '" class="badge bg-danger delete"><i class="mdi mdi-delete" style="font-size:15px;"></i></a>';
    // }

    //Print
    if ($row->status == "closed") {
        $printAction = '<a href="' . route('print-ticket', ['id' => $row->id]) . '" class="badge bg-secondary" target="_BLANK"><i class="mdi mdi-printer" style="font-size:15px;"></i></a>';
    }
    $detailAction = '<a href="' . route('ticket.show', $row) . '" style="margin-left:4px" class="badge bg-info"><i class="mdi mdi-eye" style="font-size:15px;"></i></a>';
    $actionHtml .= $editAction ?? '';
    $actionHtml .= $deleteAction ?? '';
    $actionHtml .= $printAction ?? '';
    $actionHtml .= $detailAction ?? '';
    $actionHtml .= '</div>';
    return $actionHtml;
}

function toDateIndo($date)
{
    $datetime = new DateTime($date);
    $day = $datetime->format('d');
    $monthNames = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $month = $monthNames[$datetime->format('m') - 1];
    $year = $datetime->format('Y');

    return $day . ' ' . $month . ' ' . $year;
}
function toDateTimeIndo($date)
{

    $datetime = new DateTime($date);
    $day = $datetime->format('d');
    $monthNames = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $month = $monthNames[$datetime->format('m') - 1];
    $year = $datetime->format('Y');
    $hour = $datetime->format('H');
    $minute = $datetime->format('i');
    return $day . ' ' . $month . ' ' . $year . ' ' . $hour . ':' . $minute;
}

function downtime($startTime, $finishTime)
{
    $start = new DateTime($startTime);
    $finish = new DateTime($finishTime);

    $diff = $start->diff($finish);
    return $diff->format('%h jam %i menit %s detik');
}
