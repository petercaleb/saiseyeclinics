<?php
use App\Models\Role;
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


/*
|---------------------------------------------------------
| Landing Page Routes
|---------------------------------------------------------
*/

Route::middleware('preventBackHistory')->group(function () {

    Route::view('/', 'front.pages.index')->name('home');
});

