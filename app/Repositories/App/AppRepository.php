<?php

namespace App\Repositories\App;

use LaravelEasyRepository\Repository;

interface AppRepository extends Repository{

    public function insertOneModel($model, array $data);
    public function updateOneModel($model, array $data);
    public function deleteOneModel($model);
    public function insertOneModelWithFile($model, array $data, $file =  null, $filePath, $key, $defaultFile = Null);
    public function updateOneModelWithFile($model, array $data, $file =  null, $filePath, $key, $oldFile);
    public function deleteOneModelWithFile($model, $file);
}
