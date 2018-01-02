<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\ProyekBahan;
use App\Models\ProyekPegawai;
use App\Models\ProyekPekerjaan;
use App\Models\ProyekResiko;
use App\Models\Evm as ModelEvm;
use App\Mppl\EVM;
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
      $evm = new Evm($proyekId);
      DB::transaction(function()use($proyek, $proyekId, $evm){
        $proyek->status = 0;
        $proyek->save();
        collect($evm->bobot_per_minggu)->map(function($item, $key) use($proyekId){
          ModelEvm::create([
              'minggu_ke' => $item['minggu_ke'], 
              'bcws_bobot' => round($item['bobot'], 2), 
              'bcws_budget' => $item['budget'],
              'proyek_id' => $proyekId
            ]);
        });
      });
      //------------------------------------------
      return response()->json($evm->bobot_per_minggu);
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
      $evm = new Evm($proyekId);
      $bcwp = ModelEvm::where('proyek_id', $proyekId)->where('status', 1)->get(['minggu_ke', 'bcwp_bobot', 'bcwp_budget']);
      $acwp = ModelEvm::where('proyek_id', $proyekId)->where('status', 1)->get(['minggu_ke', 'acwp_budget']);

      $total = 0;
      $chart_bcws = collect($evm->bobot_per_minggu)->map(function($item, $key)use(&$total){
        $total = $item['budget']+$total;
        return $total;
      });

      $total = 0;
      $chart_bcwp = $bcwp->map(function($item, $key)use(&$total){
        $total = $item['bcwp_budget']+$total;
        return $total;
      });

      $total = 0;
      $chart_acwp = $acwp->map(function($item, $key)use(&$total){
        $total = $item['acwp_budget']+$total;
        return $total;
      });
      $labels = collect($evm->bobot_per_minggu)->pluck('minggu_ke')->map(function($item, $key){
        return 'Minggu ke -'.$item;
      });
      $chart = [
        'labels' => $labels,
        'datasets' => [
          [
            'label' => 'BCWS',
            'data' => $chart_bcws,
            'fill' => false,
            'borderColor' => '#4286f4'
          ],
          [
            'label' => 'BCWP',
            'data' => $chart_bcwp,
            'fill' => false,
            'borderColor' => '#42f456'
          ],
          [
            'label' => 'ACWP',
            'data' => $chart_acwp,
            'fill' => false,
            'borderColor' => '#d61d58'
          ],
        ],
      ];
      return response()->json([
        'bcws' => $evm->bobot_per_minggu,
        'kegiatan' => $evm->kegiatan,
        'bcwp' => $bcwp,
        'acwp' => $acwp,
        'chart' => $chart//['data' => ]
      ]);
    }

    public function PostData(Request $request, $proyekId)
    {
      $this->validate($request, [
        'percent' => 'required|numeric',
        'budget' => 'required|numeric',
        'minggu_ke' => 'required',
      ]);
      $proyek = Proyek::find($proyekId);

      $data = ModelEvm::where('minggu_ke', $request->minggu_ke)
        ->where('proyek_id', $proyekId)
        ->first();
      $data->bcwp_bobot = $request->percent;
      $data->bcwp_budget = round($proyek->nilai_kontrak * ($request->percent/100));
      $data->acwp_budget = $request->budget;
      $data->status = 1;
      $data->save();

      return response()->json([
        'message' => 'Data Berhasil Disimpan',
      ], 201);
    }
}
