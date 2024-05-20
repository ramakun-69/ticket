<?php

namespace App\Http\Controllers\Master;

use App\Models\MDepartment;
use Illuminate\Http\Request;
use App\Traits\ResponseOutput;
use App\Http\Controllers\Controller;
use App\Repositories\App\AppRepository;
use App\Http\Requests\Master\DepartmentRequest;

class CDepartment extends Controller
{
    use ResponseOutput;
    protected $appRepository;
    public function __construct(AppRepository $appRepository)
    {
        $this->appRepository = $appRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = __("Department");
        return view("pages.master-data.department.index", compact("title"));
    }

    public function store(DepartmentRequest $request)
    {
        return $this->safeApiCall(function () use ($request) {
            $data = $request->validated();
            $model = new MDepartment();
            if ($data['id']) {
                $this->appRepository->updateOneModel($model, $data);
                return $this->responseSuccess(['message' =>  __('Successfully Updated') . " " . __('Department')]);
            } else {
                $this->appRepository->insertOneModel($model, $data);
                return $this->responseSuccess(['message' => __('Added Successfully') . " " . __('Department')]);
            }
        });
    }

    public function edit(MDepartment $department)
    {
        return $this->safeApiCall(function() use($department){
            return $this->responseSuccess($department);
        });
    }

    public function destroy(MDepartment $department)
    {
        return $this->safeApiCall(function () use ($department){
            $this->appRepository->deleteOneModel($department);
            return $this->responseSuccess(['message'=> __("Successfully Delete"). __("Department")]);
        });
    }
}
