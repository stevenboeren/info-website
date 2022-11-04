<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Auth;

/*
    AmoClient Auth
*/

Route::get('/login', function(){
	return redirect('/amoclient/redirect');
})->name('login');

Route::post('/logout', function(){
    Auth::logout();

	return redirect('/amoclient/logout');
})->name('logout');

Route::get('/amoclient/ready', function(){
	return redirect()->route('sites.index');
});

/*
    App
*/

Route::get('/', [SiteController::class, 'random'])->name('home');
Route::get('/en', [SiteController::class, 'randomEnglish'])->name('home.english');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('beheer', SiteController::class, [
            'names' => 'sites'
        ])->parameters([
            'beheer' => 'site'
        ])->except([
            'show'
        ]);
    });

// Overrides default Resource route
Route::get('/site/{site}', [SiteController::class, 'show'])->name('sites.show');
