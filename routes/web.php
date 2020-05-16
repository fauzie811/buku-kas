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

// Auth::routes();
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'DashboardController@index')->name('dashboard');
Route::get('json/last-year-chart', 'DashboardController@lastYearChart');
Route::get('profile', 'MeController@showProfile')->name('profile');
Route::post('profile', 'MeController@saveProfile');
Route::get('profile/change-password', 'MeController@showPasswordForm')->name('profile.change-password');
Route::post('profile/change-password', 'MeController@savePassword');
Route::resource('cash-types', 'CashTypeController');
Route::get('cashes/excel', 'CashController@excel')->name('cashes.excel');
Route::resource('cashes', 'CashController');
Route::resource('cashbooks', 'CashbookController');
