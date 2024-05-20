<?php

namespace App\Http\Controllers\Master;

use App\Models\MAsset;
use App\Models\MLocation;
use Illuminate\Http\Request;
use App\Traits\ResponseOutput;
use App\Models\MProductionAsset;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\AssetRequest;
use App\Repositories\App\AppRepository;
use App\Http\Requests\Master\ProductionAssetRequest;

class CProductionAsset extends Controller
{
    use ResponseOutput;
    protected $appRepository;

    public function __construct(AppRepository $appRepository)
    {
        $this->appRepository = $appRepository;
    }

    public function index()
    {
        $title = __("Production Asset");
        $location = MLocation::all();
        return view("pages.master-data.production-asset.index", compact("title", "location"));
    }
    public function machine()
    {
        $title = __("Machine Asset");
        $location = MLocation::all();
        return view("pages.master-data.production-asset.index", compact("title", "location"));
    }

    public function store(AssetRequest $request)
    {
        return $this->safeApiCall(function () use ($request) {
            $data = $request->validated();
            $data["type"] = "produksi";
            $model = new MAsset();
            if ($data['id']) {
                $this->appRepository->updateOneModel($model, $data);
                return $this->responseSuccess(['message' =>  __('Successfully Updated') . " " . __('Production Asset')]);
            } else {
                $this->appRepository->insertOneModel($model, $data);
                return $this->responseSuccess(['message' => __('Added Successfully') . " " . __('Production Asset')]);
            }
        });
    }

    public function edit(MAsset $production_asset)
    {
        return $this->safeApiCall(function () use ($production_asset) {
            return $this->responseSuccess($production_asset);
        });
    }

    public function destroy(MAsset $production_asset)
    {
        return $this->safeApiCall(function () use ($production_asset){
            $this->appRepository->deleteOneModel($production_asset);
            return $this->responseSuccess(['message'=> __("Successfully Delete"). __("Production Asset")]);
        });
    }
}
