<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class Report implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $data;
    protected $no = 1;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {
        $user = Auth::user()->pegawai;
        $role = Auth::user()->role;
        $report = Ticket::filteredReport($user, $role, $this->data)->get();
        return $report;
    }


    public function headings(): array
    {
        return [
            'No',
            __('Ticket Number'),
            __('Staff Name'),
            __('Asset Name') . "/" . __("Service"),
            __('Type'),
            __('Damaged Time'),
            __('Downtime'),
            __('Finish Time'),
            __('Status'),
        ];
    }

    public function map($ticket): array
    {

        return [
            $this->no++,
            $ticket->ticket_number,
            $ticket->user->name,
            $ticket->asset->name,
            __($ticket->type),
            toDateIndo($ticket->damage_time),
            toDateTimeIndo($ticket->start_time),
            toDateTimeIndo($ticket->finish_time),
            __($ticket->status),

        ];
    }
}
