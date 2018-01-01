<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;

class BahanBakuController extends Controller
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
        return response()->json(BahanBaku::all(), 200);
      }
      return view('content.bahan-baku.index');
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
        'bahan_baku' => 'required',
        'satuan' => 'required',
        'harga' => 'required|numeric',
      ]);

      $bahan = new BahanBaku();
      $bahan->bahan_baku = $request->bahan_baku;
      $bahan->satuan = $request->satuan;
      $bahan->harga = $request->harga;
      $bahan->save();

      return response()->json([
        'message' => 'Data Berhasil ditambahkan',
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
        $bahan = BahanBaku::find($id);

        return response()->json($bahan, 200);
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
        'bahan_baku' => 'required',
        'satuan' => 'required',
        'harga' => 'required|numeric',
      ]);

      $bahan = BahanBaku::find($id);
      $bahan->bahan_baku = $request->bahan_baku;
      $bahan->satuan = $request->satuan;
      $bahan->harga = $request->harga;
      $bahan->save();

      return response()->json([
        'message' => "Data Berhasil Diubah",
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
        $bahan = BahanBaku::find($id);
        $bahan->delete();

        return response()->json([
          'message' => 'Data Berhasil dihapus',
          'deleted' => true
        ], 201);
    }
}
