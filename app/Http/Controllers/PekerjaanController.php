<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pekerjaan;

class PekerjaanController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if(request()->wantsJson()){
        return response()->json(Pekerjaan::all(), 200);
      }
      return view('content.pekerjaan.index');
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
          'pekerjaan' => 'required'
        ]);

        $pekerjaan = new Pekerjaan();
        $pekerjaan->pekerjaan = $request->pekerjaan;
        $pekerjaan->save();

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
        return response()->json(Pekerjaan::find($id), 200);
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
        $pekerjaan = Pekerjaan::find($id);
        $pekerjaan->pekerjaan = $request->pekerjaan;
        $pekerjaan->save();

        return response()->json([
          'message' => 'Data Berhasil diubah',
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
        $pekerjaan = Pekerjaan::find($id);
        $pekerjaan->delete();

        return response()->json([
          'message' => 'Data Berhasil dihapus',
          'updated' => true
        ], 201);
    }
}
