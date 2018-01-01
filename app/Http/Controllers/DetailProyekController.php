<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\ProyekBahan;
use App\Models\ProyekPegawai;
use App\Models\ProyekPekerjaan;
use App\Models\ProyekResiko;
use App\Mppl\CPM;
use App\Mppl\EVM;
use App\Mppl\EVMBelum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailProyekController extends Controller
{
    public function __construct()
    {
      // $this->middleware('auth');
    }

    public function index($id)
    {
      $proyek = Proyek::find($id);
      if(request()->wantsJson()){
        return response()->json($proyek, 200);
      }
      return view('content.detail.index', compact('proyek'));
    }

    public function pekerjaan($proyekId)
    {
      $proyek = Proyek::find($proyekId);
      $pekerjaan = ProyekPekerjaan::with(['pendahulu' => function($q){
        $q->select('id', 'initial')
          ->orderBy('initial');
      }])->where('proyek_id', $proyekId)->get();
      $data = $pekerjaan->map(function ($item, $key) use($proyek) {
          return [
            "id" => $item->id,
            "initial" => $item->initial,
            "harga" => $item->harga,
            "durasi" => $item->durasi,
            "bobot" => round(($item->harga / $proyek->nilai_kontrak) * 100, 4) ,
            "nama_pekerjaan" => $item->nama_pekerjaan,
            "pendahulu" => implode(", ", $item->pendahulu->pluck('initial')->toArray())
          ];
      });
      return response()->json($data, 200);
    }

    public function createPekerjaan($proyekId, Request $request)
    {
      $this->validate($request, [
        'initial' => 'required',
        'pekerjaan' => 'required',
        'harga' => 'required|numeric',
        'durasi' => 'required|numeric',
      ]);

      DB::transaction(function() use ($proyekId, $request){
        $pekerjaan = new ProyekPekerjaan();
        $pekerjaan->initial = $request->initial;
        $pekerjaan->harga = $request->harga;
        $pekerjaan->durasi = $request->durasi;
        $pekerjaan->pekerjaan_id = $request->pekerjaan;
        $pekerjaan->proyek_id = $proyekId;
        $pekerjaan->save();
        if(count($request->pekerjaan_sebelumnya) > 1){
          foreach ($request->pekerjaan_sebelumnya as $key => $value) {
            $pekerjaan->pendahulu()->attach($value); 
          }
        }else{
          if($request->pekerjaan_sebelumnya[0] != 0){
            $pekerjaan->pendahulu()->attach($request->pekerjaan_sebelumnya[0]);
          }
        }

      });

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

    public function lockProject($proyekId)
    {
      $proyek = Proyek::find($proyekId);
      $proyek->status = 0;
      $proyek->save();
      //------------------------------------------

      $cpm = new CPM($proyekId);
      $pekerjaan_fiter = $cpm->result();
      



      return response()->json($pekerjaan_fiter);
    }

    public function resiko($proyekId)
    {
      $resiko = ProyekResiko::where('proyek_id', $proyekId)->get();
      return response()->json($resiko, 200);
    }

    public function createResiko($proyekId, Request $request)
    {
      $this->validate($request, [
        'kode' => 'required|min:2',
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
      $bahan = ProyekBahan::with('bahan')->where('proyek_id', $proyekId)->get();
      return response()->json($bahan, 200);
    }

    public function createBahan($proyekId, Request $request)
    {
      $this->validate($request, [
        'bahan' => 'required',
        'jumlah' => 'required|numeric',
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
      return response()->json($pegawai, 200);
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
      $evm = new EVM($proyekId);
      return response()->json(
        $evm->result_cpm()
      );      
    }

    public function evm($proyekId)
    {
      $evm = new EVM($proyekId);

      return response()->json(
        $evm->result_evm()
      );
    }
}
