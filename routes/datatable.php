<?php 

use App\Http\Controllers\CDatatable;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::prefix('/datatable')
    ->name('datatable.')
    ->controller(CDatatable::class)
    ->group(function () {
        Route::get('mLocation', 'mLocation')->name('mLocation');
        Route::get('mShift', 'mShift')->name('mShift');
        Route::get('mDepartment', 'mDepartment')->name('mDepartment');
        Route::get('mPegawai', 'mPegawai')->name('mPegawai');
        Route::get('mProduction-asset', 'mProductionAsset')->name('mProduction-asset');
        Route::get('mIt-asset', 'mItAsset')->name('mIt-asset');
        Route::get('tickets','ticket')->name('tickets');
        Route::get('my-ticket','myTicket')->name('myTicket');
        Route::get('history','history')->name('history');
    });
});