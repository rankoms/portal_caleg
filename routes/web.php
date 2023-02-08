<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PeopleController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});
Auth::routes();

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');
Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');
Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::get('/people/list', [PeopleController::class, 'list'])->name('people.list');
    Route::resource('people', PeopleController::class);


    Route::group(['prefix' => 'news'], function () {
        Route::get('/', [NewsController::class, 'index'])->name('news.index');
        Route::get('/list', [NewsController::class, 'list'])->name('news.list');
        Route::get('/list1', [NewsController::class, 'list1'])->name('news.list1');
        Route::get('/list1_v2', [NewsController::class, 'list1_v2'])->name('news.list1_v2');
        Route::get('/list_home', [NewsController::class, 'list_home'])->name('news.list_home');
        Route::get('/detail/{id}', [NewsController::class, 'detail'])->name('news.detail');
        Route::get('/{id}', [NewsController::class, 'show'])->name('news.show');

        // Route::resource('news', NewsController::class);
        Route::post('/store', [NewsController::class, 'store'])->name('news.store');
        Route::get('/create', [NewsController::class, 'create'])->name('news.create');
        Route::post('/update/{id}', [NewsController::class, 'update'])->name('news.update');
        Route::delete('/destroy/{id}', [NewsController::class, 'destroy'])->name('news.destroy');
    });
});
