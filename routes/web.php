<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\http\Controllers\SampleController;
use App\http\Controllers\LiController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;

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
    return view('home');
});

Route::get('/searchSample', function () {
    return view('search');
});

Route::post('/searchSample', [SearchController::class, 'search']);

Route::get('show/{id}', [SearchController::class, 'show']);

Route::get('/sampleEdit/create', [SampleController::class,'create']);

Route::post('/sampleEdit', [SampleController::class, 'store']);

Route::get('li/{liname}', [LiController::class, 'getLiId']);

Route::get('test', [TestController::class, 'testAddTel']);