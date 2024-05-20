<?php

namespace App\Http\Controllers\Ticket;

use App\Models\MAsset;
use App\Models\Ticket;
use App\Models\MPegawai;
use Illuminate\Http\Request;
use App\Traits\ResponseOutput;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Ticket\TicketRequest;
use App\Repositories\Ticket\TicketRepository;

class CTicket extends Controller
{
    use ResponseOutput;
    protected $ticketRepository;
    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = __("Support Ticket");
        $productionAssets = MAsset::where("type", "produksi")->get();
        $itAssets = MAsset::where("type", "it")->get();
        $technician = MPegawai::whereHas('user', function ($query) {
            $query->where('role', 'teknisi')
                ->where('department_id', Auth::user()->pegawai?->department_id);
        })->get();
        return view("pages.ticket.index", compact("title", "productionAssets", "itAssets", "technician"));
    }
    public function myTicket()
    {
        $this->authorize('myTicket');
        $title = __("My Support Ticket");
        $productionAssets = MAsset::where("type", "produksi")->get();
        $itAssets = MAsset::where("type", "it")->get();
        $technician = MPegawai::whereHas('user', function ($query) {
            $query->where('role', 'teknisi');
        })->where('department_id', Auth::user()->pegawai->department_id)->get();
        return view("pages.ticket.my-ticket", compact("title", "productionAssets", "itAssets", "technician"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketRequest $request)
    {
        return $this->safeApiCall(function () use ($request) {
            $data = $request->validated();
            if ($data['id']) {

                if (Auth::user()->role == 'atasan') {
                    $this->ticketRepository->confirmByBoss($data);
                    return $this->responseSuccess(['message' => __("Support ticket confirmed successfully")]);
                } elseif (Auth::user()->role == 'teknisi') {
                    $this->ticketRepository->tehcnicianProcess($data);
                    return $this->responseSuccess(['message' => __("Support ticket processed successfully")]);
                } elseif (Auth::user()->role == 'atasan teknisi') {

                    $this->ticketRepository->confirmByTechnicianBoss($data);
                    return $this->responseSuccess(['message' => __("Support ticket confirmed successfully")]);
                }
            } else {
                if (Auth::user()->role == 'staff') {
                    $this->ticketRepository->storeStaff($data);
                } else {
                    $this->ticketRepository->storeNonStaff($data);
                }
                return $this->responseSuccess(['message' => __('Created Successfully') . __('Support Ticket')]);
            }
        });
    }

    public function confirm(Request $request)
    {
        return $this->safeApiCall(function () use ($request) {
            $this->ticketRepository->confirmByTechnician($request);
            return $this->responseSuccess(['message' => __('Confirm Successfully') . __('Support Ticket')]);
        });
    }
    public function close(Request $request)
    {
        return $this->safeApiCall(function () use ($request) {
            $this->ticketRepository->closeTicket($request);
            return $this->responseSuccess(['message' => __('Confirm Successfully') . __('Support Ticket')]);
        });
    }
    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $title = __('Detail Ticket');
        return view('pages.ticket.detail', compact('title', 'ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        return $this->safeApiCall(function () use ($ticket) {
            return $this->responseSuccess($ticket);
        });
    }

    public function print(Request $request)
    {
        $ticket = Ticket::where('id', $request->id)->first();
        $pdf = Pdf::loadView('pages.ticket.print', ['ticket' => $ticket]);
        return $pdf->stream();
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function ticketAssets(Request $request)
    {
        $type = ($request->type == "it") ? "it" : "produksi";
        $categories = [
            "it" => "it",
            "machine" => "mesin",
            "utilities" => "utilities",
            "sipil" => "sipil",
        ];
        $category = $categories[$request->type] ?? null;
        $assets = MAsset::where("type", $type)
            ->when($type === "produksi", function ($query) use ($category) {
                return $query->where("category", $category);
            })
            ->get();
        return response()->json($assets);
    }
    public function assetInfo(Request $request)
    {
        $assets = MAsset::findOrFail($request->id);
        return response()->json($assets);
    }
}
