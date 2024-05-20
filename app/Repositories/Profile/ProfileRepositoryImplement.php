<?php

namespace App\Repositories\Profile;

use App\Models\MPegawai;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use LaravelEasyRepository\Implementations\Eloquent;

class ProfileRepositoryImplement extends Eloquent implements ProfileRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function updateProfilePicture($user, $newProfilePicture)
    {
        $oldProfilePicture = $user->foto;
        $fotoPath = $newProfilePicture->store('profile-image');
        $user->foto = $fotoPath;
        $user->save();
        if ($oldProfilePicture != Null) {
            Storage::delete($oldProfilePicture);
        }
        return $user;
    }
    public function updateProfile($request, $user)
    {

        $data = $request->validated();
        $user->update($data);
        if (Auth::user()->role != "admin") {
            $dataPegawai = [
                'name' => $data['name'],
                'address' => $data['address'],
                'phone' => $data['phone'],
            ];
            MPegawai::where("user_id", $user->id)->update($dataPegawai);
            $user->username = $data["phone"];
            $user->save();
        }
        return $user;
    }
}
