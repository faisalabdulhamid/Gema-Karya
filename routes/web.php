<?php
use Illuminate\Support\Facades\Auth;

Route::get('/user', function(){
  $user = Auth::user();
  return response()->json($user, 200);
})->middleware('auth');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home')->middleware('auth');

Route::resource('proyek', 'ProyekController', [
	'only' => ['index', 'store', 'show', 'update', 'destroy'], 
	'names'=> ['index' => 'proyek']
]);
Route::resource('resiko', 'ResikoController', [
	'except' => ['edit', 'create'],
	'names'=> ['index' => 'resiko']
]);
Route::resource('pekerjaan', 'PekerjaanController', [
	'only' => ['index', 'store', 'show', 'update', 'destroy'], 
	'names'=> ['index' => 'pekerjaan']
]);
Route::resource('bahan-baku', 'BahanBakuController', [
	'only' => ['index', 'store', 'show', 'update', 'destroy'], 
	'names'=> ['index' => 'bahan-baku']
]);
Route::resource('pegawai', 'PegawaiController', [
	'only' => ['index', 'store', 'show', 'update', 'destroy'], 
	'names'=> ['index' => 'pegawai']
]);


// Route::get('detail/{param}', 'DetailProyekController@index')->name('detail');
Route::prefix('detail')->name('detail')->group(function(){
    Route::get('/{param}', 'DetailProyekController@index')->name('.index');
    Route::post('/{param}', 'DetailProyekController@lockProject')->name('.lock');

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

    Route::get('/{proyekId}/cpm', 'DetailProyekController@cpm')->name('.cpm');
    Route::get('/{proyekId}/evm', 'DetailProyekController@evm')->name('.cpm');
    Route::post('/{proyekId}/post-data', 'DetailProyekController@PostData')->name('.post-data');
});
