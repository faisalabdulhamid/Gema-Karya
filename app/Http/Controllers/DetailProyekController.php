<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\ProyekBahan;
use App\Models\ProyekPegawai;
use App\Models\ProyekPekerjaan;
use App\Models\ProyekResiko;
use App\Mppl\CPM;
use App\Mppl\EVM;
use Illuminate\Http\Request;

class DetailProyekController extends Controller
{
    public function index($id)
    {
      $proyek = Proyek::find($id);
      if(request()->ajax()){
        return response()->json($proyek, 200);
      }
      return view('content.detail.index', compact('proyek'));
    }

    public function pekerjaan($proyekId)
    {
      $pekerjaan = ProyekPekerjaan::where('proyek_id', $proyekId)->get();
      $data = [];
      foreach ($pekerjaan as $value) {
        $row = [];
        $row['id'] = $value->id;
        $row['initial'] = $value->initial;
        $row['pekerjaan'] = $value->pekerjaan->pekerjaan;
        $row['harga'] = $value->harga;
        $row['durasi'] = $value->durasi;
        $row['pendahuluan'] = $value->pendahuluan;
        $data[] = $row;
      }
      return response()->json($data, 200);
    }

    public function createPekerjaan($proyekId, Request $request)
    {
      $this->validate($request, [
        'initial' => 'required',
        'pekerjaan' => 'required',
        'harga' => 'required',
        'durasi' => 'required',
      ]);

      $pekerjaan = new ProyekPekerjaan();
      $pekerjaan->initial = $request->initial;
      $pekerjaan->harga = $request->harga;
      $pekerjaan->durasi = $request->durasi;
      $pekerjaan->pekerjaan_id = $request->pekerjaan;
      $pekerjaan->proyek_id = $proyekId;

      if(count($request->pekerjaan_sebelumnya) > 1){
        $arr = [];
        foreach ($request->pekerjaan_sebelumnya as $key => $value) {
          if($value != 0){
            $arr[] = $value;  
          }
        }
        $pekerjaan->pekerjaan_sebelumnya = json_encode($arr);
      }else{
        if($request->pekerjaan_sebelumnya[0] != 0){
          $pekerjaan->pekerjaan_sebelumnya = json_encode($request->pekerjaan_sebelumnya);
        }
      }
      $pekerjaan->save();

      return response()->json([
        'message' => 'Data Berhasil Ditambahkan',
      ], 201);
    }

    public function deletePekerjaan($proyekId, $pekerjaanId)
    {
      $pekerjaan = ProyekPekerjaan::find($pekerjaanId);
      $pekerjaan->delete();
      return response()->json([
        'message' => 'Data Berhasil Dihapus',
      ], 201);
    }

    public function resiko($proyekId)
    {
      $resiko = ProyekResiko::where('proyek_id', $proyekId)->get();
      $data = [];
      foreach ($resiko as $value) {
        $row = [];
        $row['id'] = $value->id;
        $row['kode'] = $value->kode;
        $row['resiko'] = $value->resiko->resiko;
        $row['nilai_dampak'] = $value->nilai_dampak;
        $row['nilai_kemungkinan'] = $value->nilai_kemungkinan;
        $row['kemungkinan'] = $value->kemungkinan;
        $row['level'] = $value->level;
        $row['mitigasi'] = $value->mitigasi;
        $data[] = $row;
      }
      return response()->json($data, 200);
    }

    public function createResiko($proyekId, Request $request)
    {
      $this->validate($request, [
        'kode' => 'required',
        'nilai_dampak' => 'required',
        'dampak' => 'required',
        'nilai_kemungkinan' => 'required',
        'kemungkinan' => 'required',
        'level' => 'required',
        'mitigasi' => 'required',
      ]);

      $resiko = new ProyekResiko();
      $resiko->kode = $request->kode;
      $resiko->nilai_dampak = $request->nilai_dampak;
      $resiko->dampak = $request->dampak;
      $resiko->nilai_kemungkinan = $request->nilai_kemungkinan;
      $resiko->kemungkinan = $request->kemungkinan;
      $resiko->level = $request->level;
      $resiko->mitigasi = $request->mitigasi;
      $resiko->resiko_id = $request->resiko;
      $resiko->proyek_id = $proyekId;
      $resiko->save();

      return response()->json([
        'message' => 'Data Berhasil Ditambahkan',
      ], 201);
    }

    public function deleteResiko($proyekId, $resikoId)
    {
      $resiko = ProyekResiko::find($resikoId);
      $resiko->delete();
      return response()->json([
        'message' => 'Data Berhasil Dihapus',
      ], 201);
    }

    public function showResiko($proyekId, $resikoId)
    {
      $resiko = ProyekResiko::find($resikoId);
      $data['kode'] = $resiko->kode;
      $data['nilai_dampak'] = $resiko->nilai_dampak;
      $data['dampak'] = $resiko->dampak;
      $data['nilai_kemungkinan'] = $resiko->nilai_kemungkinan;
      $data['kemungkinan'] = $resiko->kemungkinan;
      $data['level'] = $resiko->level;
      $data['mitigasi'] = $resiko->mitigasi;
      $data['resiko'] = $resiko->resiko->resiko;

      return response()->json($data, 201);
    }

    public function bahan($proyekId)
    {
      $bahan = ProyekBahan::where('proyek_id', $proyekId)->get();
      $data = [];
      foreach ($bahan as $value) {
        $row = [];
        $row['id'] = $value->id;
        $row['bahan'] = $value->bahan->bahan_baku;
        $row['jumlah'] = $value->jumlah;
        $row['satuan'] = $value->bahan->satuan;
        $row['harga'] = number_format($value->bahan->harga, 2, ',', '.');
        $row['total'] = number_format($value->bahan->harga * $value->jumlah, 2, ',', '.');
        $data[] = $row;
      }
      return response()->json($data, 200);
    }

    public function createBahan($proyekId, Request $request)
    {
      $this->validate($request, [
        'bahan' => 'required',
        'jumlah' => 'required',
      ]);

      $bahan = new ProyekBahan();
      $bahan->jumlah = $request->jumlah;
      $bahan->bahan_id = $request->bahan;
      $bahan->proyek_id = $proyekId;
      $bahan->save();

      return response()->json([
        'message' => 'Data Berhasil Ditambahkan',
      ], 201);
    }

    public function deleteBahan($proyekId, $bahanId)
    {
      $bahan = ProyekBahan::find($bahanId);
      $bahan->delete();
      return response()->json([
        'message' => 'Data Berhasil Dihapus',
      ], 201);
    }

    public function pegawai($proyekId)
    {
      $pegawai = ProyekPegawai::where('proyek_id', $proyekId)->get();
      $data = [];
      foreach ($pegawai as $value) {
        $row = [];
        $row['id'] = $value->id;
        $row['pegawai'] = $value->pegawai->nama;
        $data[] = $row;
      }
      return response()->json($data, 200);
    }

    public function createPegawai($proyekId, Request $request)
    {
      $this->validate($request, [
        'pegawai' => 'required',
      ]);

      $pegawai = new ProyekPegawai();
      $pegawai->pegawai_id = $request->pegawai;
      $pegawai->proyek_id = $proyekId;
      $pegawai->save();

      return response()->json([
        'message' => 'Data Berhasil Ditambahkan',
      ], 201);
    }

    public function deletePegawai($proyekId, $pegawaiId)
    {
      $pegawai = ProyekPegawai::find($pegawaiId);
      $pegawai->delete();
      return response()->json([
        'message' => 'Data Berhasil Dihapus',
      ], 201);
    }

    public function cpm($proyekId)
    {
      $cpm = new EVM($proyekId);
      
      return response()->json(
        $cpm->respon_cpm()
      );
    }

    public function evm($proyekId)
    {
      $evm = new EVM($proyekId);

      return response()->json(
        $evm->respon_data()
      );
    }
}
