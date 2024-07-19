<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Ticket;
use Illuminate\Support\Str;
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
            __('Asset Code'),
            __('Location') . "/" . __("PIC"),
            __('Category'),
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
            $ticket->asset->code,
            $ticket->asset->location->name ? $ticket->asset->location->name : $ticket->asset->user->name ,
            Str::ucfirst(__($ticket->asset?->category)),
            __($ticket->type),
            toDateTimeIndo($ticket->damage_time),
            downtime($ticket->start_time, $ticket->finish_time),
            toDateTimeIndo($ticket->finish_time),
            __($ticket->status),

        ];
    }
}
