<?php

namespace App\Http\Controllers\Master;

use App\Models\User;
use App\Models\MAsset;
use App\Models\MLocation;
use Illuminate\Http\Request;
use App\Traits\ResponseOutput;
use App\Http\Controllers\Controller;
use App\Repositories\App\AppRepository;
use App\Http\Requests\Master\AssetRequest;

class CItAsset extends Controller
{
    use ResponseOutput;
    protected $appRepository;

    public function __construct(AppRepository $appRepository)
    {
        $this->appRepository = $appRepository;
    }

    public function index()
    {
        $title = __("IT Asset");
        $pic = User::whereNot('role', 'admin')->get();
        return view("pages.master-data.it-asset.index", compact("title", "pic"));
    }

    public function store(AssetRequest $request)
    {
        return $this->safeApiCall(function () use ($request) {
            $data = $request->validated();
            $data["type"] = "it";
            $model = new MAsset();
            if ($data['id']) {
                $this->appRepository->updateOneModel($model, $data);
                return $this->responseSuccess(['message' =>  __('Successfully Updated') . " " . __('IT Asset')]);
            } else {
                $this->appRepository->insertOneModel($model, $data);
                return $this->responseSuccess(['message' => __('Added Successfully') . " " . __('IT Asset')]);
            }
        });
    }

    public function edit(MAsset $it_asset)
    {
        return $this->safeApiCall(function () use ($it_asset) {
            return $this->responseSuccess($it_asset);
        });
    }

    public function destroy(MAsset $it_asset)
    {
        return $this->safeApiCall(function () use ($it_asset) {
            $this->appRepository->deleteOneModel($it_asset);
            return $this->responseSuccess(['message' => __("Successfully Delete") . __("IT Asset")]);
        });
    }
}
