<?php

namespace App\Repositories\App;

use App\Models\App;
use Illuminate\Support\Facades\Storage;
use LaravelEasyRepository\Implementations\Eloquent;

class AppRepositoryImplement extends Eloquent implements AppRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    

    public function insertOneModel($model, array $data)
    {
        return $model->create($data);
    }

    public function updateOneModel($model, array $data)
    {

        return $model->where('id', $data['id'])->update($data);
    }
    public function deleteOneModel($model)
    {
        return $model->delete();
    }

    
    public function insertOneModelWithFile($model, array $data, $file =  null, $filePath, $key, $defaultFile = Null)
    {
        if ($file != null) {
            $data[$key] = $file->store($filePath);
        } else {
            $data[$key] = $defaultFile;
        }
        return $model->create($data);
    }

    public function updateOneModelWithFile($model, array $data, $file =  null, $filePath, $key, $oldFile)
    {
        if ($file != null) {
            if (Storage::fileExists($oldFile)) {
                Storage::delete($oldFile);
            }
            $data[$key] = $file->store($filePath);
        } else {
            $data[$key] = $oldFile;
        }

        return $model->where('id', $data['id'])->update($data);
    }

    public function deleteOneModelWithFile($model, $file)
    {
        if (Storage::fileExists($file)) {
            Storage::delete($file);
        }
        return $model->delete();
    }
}
