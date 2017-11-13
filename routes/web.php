<?php
use Illuminate\Support\Facades\Auth;

Route::get('/user', function(){
  $user = Auth::user();
  return response()->json($user, 200);
})->middleware('auth');


Route::resource('proyek', 'ProyekController')->middleware('auth');
Route::resource('resiko', 'ResikoController')->middleware('auth');
Route::resource('pekerjaan', 'PekerjaanController')->middleware('auth');
Route::resource('bahan-baku', 'BahanBakuController')->middleware('auth');
Route::resource('pegawai', 'PegawaiController')->middleware('auth');

Route::prefix('detail')->name('detail')->middleware('auth')->group(function(){
    Route::get('/{param}', 'DetailProyekController@index')->name('.index');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home')->middleware('auth');
