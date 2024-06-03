<?php

namespace App\Http\Controllers\Master;

use Carbon\Carbon;
use App\Models\MShift;
use App\Events\ShiftUpdated;
use Illuminate\Http\Request;
use App\Traits\ResponseOutput;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\App\AppRepository;
use App\Http\Requests\Master\ShiftRequest;

class CShift extends Controller
{
    use ResponseOutput;
    protected $appRepository;
    public function __construct(AppRepository $appRepository)
    {
        $this->appRepository = $appRepository;
    }
    public function index()
    {
        $title = __("Shift");
        return view("pages.master-data.shift.index", compact("title"));
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
    public function store(ShiftRequest $request)
    {
        return $this->safeApiCall(function () use ($request) {
            $data = $request->validated();
            $model = new MShift();
            if ($data['id']) {
                $this->appRepository->updateOneModel($model, $data);
                $activeShiftName = setShift(); 
                ShiftUpdated::dispatch($activeShiftName);
                return $this->responseSuccess(['message' =>  __('Successfully Updated') . " " . __('Shift')]);
            } else {
                $this->appRepository->insertOneModel($model, $data);
                $activeShiftName = setShift(); 
                ShiftUpdated::dispatch($activeShiftName);
                return $this->responseSuccess(['message' => __('Added Successfully') . " " . __('Shift')]);
            }
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MShift $shift)
    {
        return $this->safeApiCall(function () use ($shift) {
            return $this->responseSuccess($shift);
        });
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
    public function destroy(MShift $shift)
    {
        DB::beginTransaction();
        return $this->safeApiCall(function () use ($shift) {
            $shift->delete();
            DB::commit();
            return $this->responseSuccess(['message' => __("Successfully Delete") . __("Location")]);
        });
    }
}
