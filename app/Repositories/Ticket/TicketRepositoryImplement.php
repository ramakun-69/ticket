<?php

namespace App\Repositories\Ticket;

use App\Models\Ticket;
use App\Models\MPegawai;
use App\Models\Sparepart;
use App\Models\MDepartment;
use App\Models\TechnicianTicket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ClosedTicketNotification;
use App\Notifications\CreateTicketNotification;
use App\Notifications\FinishTicketNotification;
use App\Notifications\ProcessTicketNotification;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Notifications\RejectTicketByBossNotification;
use App\Notifications\RejectTicketByTechnicianNotification;

class TicketRepositoryImplement extends Eloquent implements TicketRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Ticket $model)
    {
        $this->model = $model;
    }

    public function storeStaff($data)
    {
        return DB::transaction(function () use ($data) {
            $boss = MPegawai::whereHas('user', function ($query) {
                $query->where('role', 'atasan');
            })->where('department_id', Auth::user()->pegawai->department_id)->first();

            $type = $data["type"] == 'it' ? "it" : "produksi";
            $ticketNumber = generateTicketNumber($data["type"]);
            $status = "waiting approval";

            $ticketData = array_merge($data, [
                'staff_id' => Auth::user()->pegawai->id,
                'boss_id' => $boss->id,
                'department_id' => Auth::user()->pegawai->department_id,
                'ticket_number' => $ticketNumber,
                'type' => $type,
                'status' => $status,
            ]);

            $ticket = $this->model->create($ticketData);
            Notification::send($boss->user, new CreateTicketNotification($ticket));

            return $ticket;
        });
    }

    public function storeNonStaff($data)
    {
        return DB::transaction(function () use ($data) {
            $department = MDepartment::where('name', ($data['type'] == "it" ? "IT" : "Engineering"))
                ->firstOrFail();

            $technicianBoss = MPegawai::whereHas('user', function ($query) {
                $query->where('role', 'atasan teknisi');
            })->where('department_id', $department->id)->first();

            // Tentukan kode berdasarkan tipe tiket
            $code = ($data["type"] == 'machine') ? "TM" : (($data["type"] == 'utilities') ? "TU" : "IT");
            $type = $data["type"] == 'it' ? "it" : "produksi";

            // Generate nomor tiket
            $ticketNumber = generateTicketNumber($code);

            $status = "waiting approval";

            // Data tiket
            $ticketData = array_merge($data, [
                'technician_boss_id' => $technicianBoss->id,
                'department_id' => $department->id, // Menggunakan department dari data yang ditemukan
                'ticket_number' => $ticketNumber,
                'type' => $type,
                'status' => $status,
            ]);

            // Buat tiket dan simpan ke database
            $ticket = $this->model->create($ticketData);

            // Kirim notifikasi ke atasan teknisi
            Notification::send($technicianBoss->user, new CreateTicketNotification($ticket));
        });
    }


    public function confirmByBoss($data)
    {
        if ($data["ticket_status"] == "waiting approval") {
            $this->approve($data);
        } else {
            $this->reject($data);
        }
    }
    public function confirmByTechnician($data)
    {
        if ($data->type == "approve") {
            $this->approve($data);
        } else {
            $this->reject($data);
        }
    }

    public function confirmByTechnicianBoss($data)
    {
        if ($data["ticket_status"] == "waiting process") {
            $this->approve($data);
        } else {
            $this->reject($data);
        }
    }

    public function closeTicket($data)
    {
        $ticket = Ticket::findOrFail($data->id);
        $ticket->update([
            'status' => "closed",
            'finish_time' => now(),
        ]);
        $staff = MPegawai::findOrFail($ticket->staff_id);
        Notification::send($staff->user, new ClosedTicketNotification($ticket));
    }
    public function tehcnicianProcess($data)
    {
        $ticket = Ticket::findOrFail($data['id']);
        $ticket->update([
            'status' => "closed",
            'action' => $data["action"],
            'finish_time' => now(),
        ]);
        
        if ($ticket->type == 'produksi') {
            $dataSparePart = [];
            foreach ($data['part_name'] as $index => $partName) {
                $dataSparePart[] = [
                    // 'ticket_id' => $ticket->id,
                    'name' => $partName,
                    'unit' => $data['unit'][$index],
                    'total' => $data['total'][$index],
                    'information' => $data['information'][$index] ?? null,
                    'created_at' => now(),
                ];
            }
           
            if (!empty($dataSparePart)) {
                foreach ($dataSparePart as &$sparePart) {
                    $sparePart['ticket_id'] = $ticket->id;
                }
                Sparepart::insert($dataSparePart);
            }
        }
        $boss = MPegawai::findOrFail($ticket->boss_id);
        $staff = MPegawai::findOrFail($ticket->staff_id);
        Notification::send($boss->user, new FinishTicketNotification($ticket));
        Notification::send($staff->user, new ClosedTicketNotification($ticket));
    }

    // Private Method

    private function approve($data)
    {
        $ticket = Ticket::findOrFail($data['id']);
        $department = MDepartment::where('name', ($ticket->type == "it" ? "IT" : "Engineering"))
            ->firstOrFail();

        if (Auth::user()->role == "atasan") {
            $this->approveByBoss($ticket, $department, $data);
        } elseif (Auth::user()->role == "atasan teknisi") {
            $this->approveByTechnicianBoss($ticket, $data);
        } elseif (Auth::user()->role == "teknisi") {
            $this->approveByTechnician($ticket);
        }
    }

    private function approveByBoss($ticket, $department, $data)
    {
        $technicianBoss = MPegawai::whereHas('user', function ($query) {
            $query->where('role', 'atasan teknisi');
        })->where('department_id', $department->id)->firstOrFail();

        $ticket->update([
            'status' => $data["ticket_status"],
            'technician_boss_id' => $technicianBoss->id
        ]);

        Notification::send($technicianBoss->user, new CreateTicketNotification($ticket));
    }
    private function approveByTechnicianBoss($ticket, $data)
    {
        $ticket->update([
            'status' => $data["ticket_status"],
        ]);
        $technicianTicket = [];
        foreach ($data['technician_id'] as $tech) {
            $technicianTicket[] = [
                'ticket_id' => $ticket->id,
                'technician_id' => $tech,
                'created_at' => now(),
            ];
        }
        TechnicianTicket::insert($technicianTicket);
        $technicians = MPegawai::whereIn('id', $data['technician_id'])->with('user')->get();
        $users = $technicians->pluck('user');
        Notification::send($users, new CreateTicketNotification($ticket));
    }

    private function approveByTechnician($ticket)
    {
        $technicianId = Auth::user()->pegawai->id;
        TechnicianTicket::where('ticket_id', $ticket->id)
            ->where('technician_id', $technicianId)
            ->update(['status' => 1]);

        // Check if all technicians have approved
        $checkTechnician = TechnicianTicket::where('ticket_id', $ticket->id)->where('status', 0)->doesntExist();
        if ($checkTechnician) {
            $ticket->update(['status' => 'process', 'start_time' => now()]);
            $technicians = TechnicianTicket::where('ticket_id', $ticket->id)
                ->where('technician_id', '!=', $technicianId)
                ->with('technician.user')
                ->get();
            Notification::send($technicians->pluck('technician.user'), new ProcessTicketNotification($ticket));
        }
    }

    private function reject($data)
    {
        $ticket = Ticket::findOrFail($data['id']);
        $technicianId = Auth::user()->pegawai->id;

        if (Auth::user()->role != 'teknisi') {
            $ticket->update(['status' => $data["ticket_status"]]);
            $staff = MPegawai::findOrFail($ticket->staff_id);
            Notification::send($staff->user, new RejectTicketByBossNotification($ticket));
        } else {
            TechnicianTicket::where('ticket_id', $ticket->id)
                ->where('technician_id', $technicianId)
                ->update(['status' => 2]);

            $technician = Auth::user();
            $technicianBoss = MPegawai::findOrFail($ticket->technician_boss_id);
            Notification::send($technicianBoss->user, new RejectTicketByTechnicianNotification($ticket, $technician));

            $totalTechnicians = TechnicianTicket::where('ticket_id', $ticket->id)->count();
            $rejectedCount = TechnicianTicket::where('ticket_id', $ticket->id)->where('status', 2)->count();
            $approvedCount = TechnicianTicket::where('ticket_id', $ticket->id)->where('status', 1)->count();

            if ($rejectedCount === $totalTechnicians) {
                $ticket->update(['status' => 'waiting approval']);
            } elseif ($approvedCount > 0) {
                $ticket->update(['status' => 'process', 'start_time' => now()]);
                $technicians = TechnicianTicket::where('ticket_id', $ticket->id)
                    ->where('technician_id', '!=', $technicianId)
                    ->with('technician.user')
                    ->get();
                Notification::send($technicians->pluck('technician.user'), new ProcessTicketNotification($ticket));
            }
        }
    }
}
