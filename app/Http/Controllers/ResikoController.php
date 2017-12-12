<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resiko;

class ResikoController extends Controller
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
      if(request()->wantsJson())
      {
        return response()->json(Resiko::all(), 200);
      }
      return view('content.resiko.index');
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
          'resiko' => 'required'
        ]);

        $resiko = new Resiko();
        $resiko->resiko = $request->resiko;
        $resiko->save();

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
        $resiko = Resiko::find($id);

        return response()->json($resiko, 200);
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
        'resiko' => 'required'
      ]);

      $resiko = Resiko::find($id);
      $resiko->resiko = $request->resiko;
      $resiko->save();

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
      $resiko = Resiko::find($id);
      $resiko->delete();

      return response()->json([
        'message' => 'Data Berhasil Dihapus',
        'saved' => true
      ], 201);
    }
}
