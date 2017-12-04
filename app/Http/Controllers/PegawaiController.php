<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if(request()->ajax()){
        return response()->json(Pegawai::all(), 200);
      }
      return view('content.pegawai.index');
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
        'nama' => 'required'
      ]);

      $pegawai = new Pegawai();
      $pegawai->nama = $request->nama;
      $pegawai->status = 'pegawai';
      $pegawai->save();

      return response()->json([
        'message' => 'Data Berhasil Ditambahakan',
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
        $pegawai = Pegawai::find($id);
        return response()->json($pegawai, 200);
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
        'nama' => 'required'
      ]);

      $pegawai = Pegawai::find($id);
      $pegawai->nama = $request->nama;
      $pegawai->save();

      return response()->json([
        'message' => 'Data Berhasil Diubah',
        'saved' => true
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
      $pegawai = Pegawai::find($id);
      $pegawai->delete();

      return response()->json([
        'message' => 'Data Berhasil Diubah',
        'saved' => true
      ], 201);
    }
}
