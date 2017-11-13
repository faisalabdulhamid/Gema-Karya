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

Route::prefix('detail')->name('detail')->group(function(){
    Route::get('/{param}', 'DetailProyekController@index')->name('.index');

    Route::get('/{proyekId}/pekerjaan', 'DetailProyekController@pekerjaan')->name('.pekerjaan');
    Route::post('/{proyekId}/pekerjaan', 'DetailProyekController@createPekerjaan')->name('.pekerjaan.create');
    Route::delete('/{proyekId}/pekerjaan/{PekerjaanId}', 'DetailProyekController@deletePekerjaan')->name('.pekerjaan.destroy');

    Route::get('/{proyekId}/resiko', 'DetailProyekController@resiko')->name('.resiko');
    Route::post('/{proyekId}/resiko', 'DetailProyekController@createResiko')->name('.resiko.create');
    Route::get('/{proyekId}/resiko/{ResikoId}', 'DetailProyekController@showResiko')->name('.resiko.show');
    Route::delete('/{proyekId}/resiko/{ResikoId}', 'DetailProyekController@deleteResiko')->name('.resiko.destroy');

    Route::get('/{proyekId}/bahan', 'DetailProyekController@bahan')->name('.bahan');
    Route::post('/{proyekId}/bahan', 'DetailProyekController@createBahan')->name('.bahan.create');
    Route::delete('/{proyekId}/bahan/{BahanId}', 'DetailProyekController@deleteBahan')->name('.bahan.destroy');

    Route::get('/{proyekId}/pegawai', 'DetailProyekController@pegawai')->name('.pegawai');
    Route::post('/{proyekId}/pegawai', 'DetailProyekController@createPegawai')->name('.pegawai.create');
    Route::delete('/{proyekId}/pegawai/{PegawaiId}', 'DetailProyekController@deletePegawai')->name('.pegawai.destroy');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home')->middleware('auth');
