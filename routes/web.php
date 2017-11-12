<?php
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/user', function(){
  $user = Auth::user();
  return response()->json($user, 200);
});//->middleware('auth');


Route::resource('proyek', 'ProyekController');
Route::resource('resiko', 'ResikoController');
Route::resource('pekerjaan', 'PekerjaanController');
Route::resource('bahan-baku', 'BahanBakuController');

Route::prefix('detail')->name('detail')->group(function(){
    Route::get('/{param}', 'DetailProyekController@index')->name('.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
