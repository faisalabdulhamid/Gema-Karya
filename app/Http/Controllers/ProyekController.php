<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProyekController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if(request()->wantsJson()){
        return response()->json(Proyek::all(), 200);
      }
      return view('content.proyek.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'nama' => 'required',
          'nilai_kontrak' => 'required',
          'tanggal_kontrak' => 'required|date',
          'tanggal_mulai' => 'required|date',
          'tanggal_selesai' => 'required|date',
          'deskripsi' => 'required',
        ]);

        $proyek = new Proyek();
        $proyek->nama = $request->nama;
        $proyek->nilai_kontrak = $request->nilai_kontrak;
        $proyek->tanggal_kontrak = $request->tanggal_kontrak;
        $proyek->tanggal_mulai = $request->tanggal_mulai;
        $proyek->tanggal_selesai = $request->tanggal_selesai;
        $proyek->deskripsi = $request->deskripsi;
        $proyek->save();

        return response()->json([
          'message' => 'Data Berhasil Ditambahkan',
          'saved' => true
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proyek = Proyek::find($id);
        return response()->json($proyek, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validate($request, [
        'nama' => 'required',
        'nilai_kontrak' => 'required',
        'tanggal_kontrak' => 'required',
        'tanggal_mulai' => 'required',
        'tanggal_selesai' => 'required',
        'deskripsi' => 'required',
      ]);

      $proyek = Proyek::find($id);
      $proyek->nama = $request->nama;
      $proyek->nilai_kontrak = $request->nilai_kontrak;
      $proyek->tanggal_kontrak = $request->tanggal_kontrak;
      $proyek->tanggal_mulai = $request->tanggal_mulai;
      $proyek->tanggal_selesai = $request->tanggal_selesai;
      $proyek->deskripsi = $request->deskripsi;
      $proyek->save();

      return response()->json([
        'message' => 'Data Berhasil Diubah',
        'updated' => true
      ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proyek = Proyek::find($id);
        $proyek->delete();

        return response()->json([
          'message' => 'Data Berhasil Dihapus',
          'deleted' => true
        ], 201);
    }
}
