<?php

use App\Http\Controllers\CDashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\CLocation;
use App\Http\Controllers\Master\CDepartment;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CProfile;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Master\CItAsset;
use App\Http\Controllers\Master\CPegawai;
use App\Http\Controllers\Master\CProductionAsset;
use App\Http\Controllers\Master\CShift;
use App\Http\Controllers\Ticket\CComment;
use App\Http\Controllers\Ticket\CReport;
use App\Http\Controllers\Ticket\CTicket;
use Illuminate\Routing\RouteGroup;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'showLoginForm']);
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [CDashboard::class, 'index'])->name('dashboard');
    Route::prefix('master-data')->name('master-data.')
        ->middleware(['checkRole:admin'])
        ->group(function () {
            Route::resource('production-assets', CProductionAsset::class);
            Route::get('machine-assets', [CProductionAsset::class, 'machine'])->name('machine-assets');
            Route::resource('it-assets', CItAsset::class);
            Route::resource('location', CLocation::class);
            Route::resource('department', CDepartment::class);
            Route::resource('employee', CPegawai::class);
            Route::resource('shift', CShift::class);
        });
    Route::middleware("checkRole:admin,staff,atasan,teknisi,atasan teknisi")
        ->controller(CTicket::class)
        ->group(function () {
            Route::resource('ticket', CTicket::class);
            Route::get('ticket-asset', 'ticketAssets')->name('ticket-asset');
            Route::get('asset-info', 'assetInfo')->name('asset-info');
            Route::put('confirm-ticket/{ticket}', [CTicket::class, 'confirm'])->name('ticket.confirm');
            Route::put('close-ticket/{ticket}', [CTicket::class, 'close'])->name('ticket.close');
        });
    Route::get('my-ticket',  [CTicket::class, 'myTicket'])->middleware("checkRole:staff,atasan,teknisi,atasan teknisi")->name('ticket.myTicket'); 
    Route::middleware("checkRole:admin,staff,atasan,teknisi,atasan teknisi")
        ->group(function () {
            Route::resource('report', CReport::class);
            Route::get('export-report', [CReport::class, 'export'])->name('report.export');
            Route::resource('profile', CProfile::class);
            Route::get('notif', [CDashboard::class, 'notif'])->name('notif');
            Route::get('read', [CDashboard::class, 'read'])->name('read');
            Route::get('print-ticket', [CTicket::class, 'print'])->name('print-ticket');
            Route::put('update-profile-picture', [CProfile::class, 'updatePicture'])->name('update-profile-picture');
            Route::resource('comment', CComment::class);
        });
});
Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
});
Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
