<?php

namespace App\Repositories\Pegawai;

use LaravelEasyRepository\Repository;

interface PegawaiRepository extends Repository{

    public function store($data);
    public function updatePegawai($data);
    public function destroy($employee);
}
