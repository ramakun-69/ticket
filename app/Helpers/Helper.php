<?php

use Carbon\Carbon;
use App\Models\MShift;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


function generateTicketNumber($type)
{
    // Tentukan kode berdasarkan tipe tiket
    $code = ($type == 'machine') ? "TM" : (($type == 'utilities') ? "TU" : (($type == 'non-mesin') ? "NM" : (($type == 'sipil') ? "TS" : "IT")));


    // Ambil nomor tiket terakhir dari tabel tickets
    $lastTicket = Ticket::latest()->first();

    if ($lastTicket) {
        // Jika ada nomor tiket terakhir, ambil nomor urut terakhir dan tambahkan 1
        $lastTicketNumber = explode('-', $lastTicket->ticket_number)[2];
        $lastTicketNumber = (int)$lastTicketNumber + 1;
        $lastTicketNumber = str_pad($lastTicketNumber, 3, '0', STR_PAD_LEFT);
        $ticketNumber = 'WO-' . $code . '-' . $lastTicketNumber;
    } else {
        // Jika tabel kosong, gunakan nomor default
        $ticketNumber = 'WO-' . $code . '-001';
    }

    return $ticketNumber;
}

function setShift()
{
    $now = Carbon::now();
    $shifts = MShift::all();
    $activeShiftId = null;
    $activeShiftName = null;

    foreach ($shifts as $shift) {
        $startShift = Carbon::createFromTimeString($shift->start_time);
        $endShift = Carbon::createFromTimeString($shift->end_time);

        // Handle shifts that pass midnight
        if ($endShift->lessThan($startShift)) {
            if (
                $now->isBetween($startShift, Carbon::tomorrow()->startOfDay()->subSecond()) ||
                $now->isBetween(Carbon::yesterday()->endOfDay()->addSecond(), $endShift)
            ) {
                $activeShiftId = $shift->id;
                $activeShiftName = $shift->name;
                break;
            }
        } else {
            if ($now->isBetween($startShift, $endShift->subSecond())) {
                $activeShiftId = $shift->id;
                $activeShiftName = $shift->name;
                break;
            }
        }
    }

    foreach ($shifts as $shift) {
        $shift->is_active = $shift->id === $activeShiftId ? 'Y' : 'N';
        $shift->save();
    }
    if (!$activeShiftId) {
        MShift::where('is_active', 'Y')->update(['is_active' => 'N']);
    }

    return $activeShiftName !== null ? $activeShiftName : __('No scheduled shift');
}

function cekShiftActive()
{
    return MShift::where('is_active', 'Y')->first();
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
        $editAction = '<a href="' . route('ticket.edit', $row) . '" class="btn btn-sm btn-warning edit me-2"><i class="mdi mdi-pencil" style="font-size:15px;"></i></a>';
    } elseif ($userRole == "teknisi") {
        if ($row->status == "waiting process" || $row->status == "process" &&  $technicianTicket->status == 0) {
            $editAction = '<a href="' . route('ticket.confirm', $row) . '" class="btn btn-primary btn-sm confirm me-2" data-id="' . $row->id . '">' . __("Confirm") . '</a>';
        } elseif ($row->status == "process" && $technicianTicket->status == 1) {
            $editAction = '<a href="' . route('ticket.edit', $row) . '" class="btn btn-success btn-sm  edit me-2"><i class="mdi mdi-check" style="font-size:15px;"></i></a>';
            $changeShiftAction = '<a href="' . route('ticket.change-shift', $row) . '" class="btn btn-warning btn-sm  change-shift me-2"><i class="mdi mdi-account-clock" style="font-size:15px;"></i></a>';
        }
    }
    //Delete
    // if ($userRole == "admin" && $row->status == "closed") {
    //     $deleteAction = '<a href="' . route('ticket.destroy', $row->id) . '" class="badge bg-danger delete"><i class="mdi mdi-delete" style="font-size:15px;"></i></a>';
    // }

    //Print
    if ($row->status == "closed") {
        $printAction = '<a href="' . route('print-ticket', ['id' => $row->id]) . '" class="btn btn-sm btn-secondary" target="_BLANK"><i class="mdi mdi-printer" style="font-size:15px;"></i></a>';
    }
    $detailAction = '<a href="' . route('ticket.show', $row) . '" style="margin-left:4px" class="btn btn-info btn-sm"><i class="mdi mdi-eye" style="font-size:15px;"></i></a>';
    $actionHtml .= $editAction ?? '';
    $actionHtml .= $changeShiftAction ?? '';
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
