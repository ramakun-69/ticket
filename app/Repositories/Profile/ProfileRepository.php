<?php

namespace App\Repositories\Profile;

use LaravelEasyRepository\Repository;

interface ProfileRepository extends Repository{

    public function updateProfilePicture($user, $newProfilePicture);
    public function updateProfile($request, $user);
}
