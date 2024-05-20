<?php

namespace App\Repositories\Pegawai;

use App\Models\User;
use App\Models\Pegawai;
use App\Models\MPegawai;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use LaravelEasyRepository\Implementations\Eloquent;

class PegawaiRepositoryImplement extends Eloquent implements PegawaiRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(MPegawai $model)
    {
        $this->model = $model;
    }

    public function store($data)
    {
        $dataUser = [
            "email" => $data["email"],
            "username" => $data["username"],
            "password" => 12345678,
            "role" => $data["role"],
        ];
        $user = User::create($dataUser);
        $data['user_id'] = $user->id;
        return  $this->model->create($data);

    }
    public function updatePegawai($data)
    {
        $this->model->where("id", $data["id"])->update(Arr::except($data, ['email', 'username', 'role']));
        User::where('id', $data["user_id"])->update([
            'email' => $data['email'],
            'username' => $data['username'],
            'role' => $data['role']
        ]);
    }
    public function destroy($employee)
    {
        if ($employee->user->foto != null) {
            Storage::delete($employee->user->foto);
        }
        $employee->user()->delete();
        $this->model->destroy($employee->id);
    }
}
