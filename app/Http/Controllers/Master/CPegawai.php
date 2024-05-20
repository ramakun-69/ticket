<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Traits\ResponseOutput;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\PegawaiRequest;
use App\Models\MDepartment;
use App\Models\MPegawai;
use App\Repositories\App\AppRepository;
use App\Repositories\Pegawai\PegawaiRepository;

class CPegawai extends Controller
{
    use ResponseOutput;
    protected $pegawaiRepository,$appRepository;
    public function __construct(PegawaiRepository $pegawaiRepository)
    {
        $this->pegawaiRepository = $pegawaiRepository;
    }

    public function index()
    {
        $title = __('Employee');
        $department = MDepartment::all();
        return view('pages.master-data.employee.index', compact('title','department'));
    }

    public function store(PegawaiRequest $request) {
        return $this->safeApiCall(function() use($request){
            $data = $request->validated();
            if ($data['id']) {
                $this->pegawaiRepository->updatePegawai($data);
                return $this->responseSuccess(['message' =>  __('Successfully Updated') . " " . __('Employee')]);
            } else {
                $this->pegawaiRepository->store($data);
                return $this->responseSuccess(['message' => __('Added Successfully') . " " . __('Employee')]);
            }
        });
    }

    public function edit(MPegawai $employee)
    {
        return $this->safeApiCall(function() use($employee){
            $pegawai = MPegawai::with('user')->find($employee->id);
            return $this->responseSuccess($pegawai);
        });
    }

    public function destroy(MPegawai $employee)
    {
        return $this->safeApiCall(function() use($employee){
            $this->pegawaiRepository->destroy($employee);
            return $this->responseSuccess(['message'=> __("Successfully Delete"). __("Employee")]);
        });
    }

}
