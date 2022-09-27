<?php

use App\Models\User;
use App\Models\Domain;
use App\Models\CurlDetail;
// use App\Models\CheckSitemap;
use App\Jobs\CheckSitemapJob;
use App\Models\CheckSitemapDomain;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\CurlDetailController;

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

Route::resource('domains', DomainController::class);
Route::post('/curl-details/{domainId}', [CurlDetailController::class, 'index']);


Route::get('tt', function(){
    $c = CheckSitemapDomain::orderBy('created_at', 'desc')->first();
    dd(json_decode($c->differences_content));
});

Route::get('aa', function(){
    $domain = Domain::where('name', 'api.iform.dk/wp-json/app/sitemaps/contenthub_composite?per_page=100000')->first();
    $checkSitemapDomain = CheckSitemapDomain::create([
        'domain_id' => $domain->id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $s = new CheckSitemapJob($domain, $checkSitemapDomain);
    $s->handle();
});

require __DIR__.'/auth.php';
