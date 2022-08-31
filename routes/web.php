<?php

use App\Http\Controllers\CurlDetailController;
use App\Http\Controllers\DomainController;
use App\Models\CurlDetail;
use App\Models\Domain;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', [DomainController::class, 'index'] )->middleware(['auth'])->name('dashboard');

// Route::get('/add-domain', [DomainController::class, 'create']);

// Route::post('/add-domain-post', [DomainController::class, 'store']);

Route::resource('domains', DomainController::class);
Route::post('/curl-details/{domainId}', [CurlDetailController::class, 'index']);

require __DIR__.'/auth.php';
