<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('proyek', 'ProyekController')->middleware('auth:api');
Route::resource('resiko', 'ResikoController')->middleware('auth:api');
Route::resource('pekerjaan', 'PekerjaanController')->middleware('auth:api');
Route::resource('bahan-baku', 'BahanBakuController')->middleware('auth:api');
Route::resource('pegawai', 'PegawaiController')->middleware('auth:api');

Route::prefix('detail')->name('detail')->middleware('auth:api')->group(function(){
    Route::get('/{param}', 'DetailProyekController@index')->name('.index');

    Route::get('/{proyekId}/pekerjaan', 'DetailProyekController@pekerjaan')->name('.pekerjaan');
    Route::post('/{proyekId}/pekerjaan', 'DetailProyekController@createPekerjaan')->name('.pekerjaan.create');
    Route::delete('/{proyekId}/pekerjaan/{PekerjaanId}', 'DetailProyekController@deletePekerjaan')->name('.pekerjaan.destroy');
    Route::get('/{proyekId}/select/pekerjaan-sebelumnya', function($proyekId){
        $pekerjaan = App\Models\ProyekPekerjaan::where('proyek_id', $proyekId)->get();
        $data = [];
        foreach ($pekerjaan as $key => $value) {
            $row['pekerjaan_id'] = $value->id;
            $row['initial'] = $value->initial;
            $row['pekerjaan'] = $value->pekerjaan()->first();
            $data[] = $row;
        }
        return response()->json($data);
    });

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

