<?php

namespace App\Http\Controllers\Master;

use App\Models\MLocation;
use Illuminate\Http\Request;
use App\Traits\ResponseOutput;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\App\AppRepository;
use App\Http\Requests\Master\LocationRequets;
use App\Models\MAsset;
use App\Models\MMachine;
use App\Models\MProductionAsset;

class CLocation extends Controller
{
    use ResponseOutput;
    protected $appRepository;
    public function __construct(AppRepository $appRepository) {
        $this->appRepository = $appRepository;
    }
    public function index()
    {
        $title = __("Location");
        return view("pages.master-data.location.index", compact("title"));
    }

    public function store(LocationRequets $request)
    {
        return $this->safeApiCall(function () use ($request) {
            $data = $request->validated();
            $model = new MLocation();
            if ($data['id']) {
                $this->appRepository->updateOneModel($model, $data);
                return $this->responseSuccess(['message' =>  __('Successfully Updated') . " " . __('Location')]);
            } else {
                $this->appRepository->insertOneModel($model, $data);
                return $this->responseSuccess(['message' => __('Added Successfully') . " " . __('Location')]);
            }
        });
    }
    public function edit(MLocation $location)
    {
        return $this->safeApiCall(function() use($location){
            return $this->responseSuccess($location);
        });
    }

    public function destroy(MLocation $location)
    {
        DB::beginTransaction();
        return $this->safeApiCall(function() use($location){
            MAsset::where('location_id', $location->id)->update(['location_id' => null]);
            $location->delete();
        DB::commit();
            return $this->responseSuccess(['message'=> __("Successfully Delete"). __("Location")]);
        }); 
    }
}
