<?php

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

Route::get('/login', function () {
    \Auth::loginUsingId(1);
    return view('auth/login');
})->name('login');

Route::middleware(['CheckToken'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('Index');

    Route::get('/InsertTA', function () {
        if(Gate::denies ('patrol_load_2152')){
            return view('InsertTA');
        }
        return view('noAuthority');
    })->name('InsertTA');

    Route::get('/InsertPatrol', function () {
        if(Gate::denies ('accident_load')){
            return view('InsertPatrol');
        }
        return view('noAuthority');
    })->name('InsertPatrol');
    Route::get('/analyze', function () {
        return view('analyze');
    })->name('analyze');
    Route::get('/MarkerMap', function () {
        return view('MarkerMap');
    })->name('MarkerMap');
    Route::get('/drinkMap', function () {
        return view('drinkMap');
    })->name('drinkMap');
    Route::get('/ChartMap', function () {
        return view('ChartMap');
    })->name('ChartMap');
    Route::get('/test', function () {
        return view('test');
    })->name('test');
    Route::get('/A1A2A3', function () {
        return view('A1A2A3');
    })->name('A1A2A3');
    Route::get('/TeachViedo', function () {
        return view('TeachViedo');
    })->name('TeachViedo');
    Route::get('/CaseCause', function () {
        return view('CaseCause');
    })->name('CaseCause');
    Route::get('/CaseTime', function () {
        return view('CaseTime');
    })->name('CaseTime');

    Route::get('/UserList', function () {
        if(Gate::allows('isAdmin')){
            return view('UserList');
        }
        return view('noAuthority');
    })->name('UserList');
    
    Route::get('/noAuthority', function () {
        return view('noAuthority');
    })->name('noAuthority');
});
