<?php
use Illuminate\Support\Facades\Auth;

Route::get('/user', function(){
  $user = Auth::user();
  return response()->json($user, 200);
})->middleware('auth');


Route::get('proyek', 'ProyekController@index')->middleware('auth')->name('proyek');
Route::get('resiko', 'ResikoController@index')->middleware('auth')->name('resiko');
Route::get('pekerjaan', 'PekerjaanController@index')->middleware('auth')->name('pekerjaan');
Route::get('bahan-baku', 'BahanBakuController@index')->middleware('auth')->name('bahan-baku');
Route::get('pegawai', 'PegawaiController@index')->middleware('auth')->name('pegawai');

Auth::routes();
Route::get('detail/{param}', 'DetailProyekController@index')->name('detail');
Route::get('/', 'HomeController@index')->name('home')->middleware('auth');
