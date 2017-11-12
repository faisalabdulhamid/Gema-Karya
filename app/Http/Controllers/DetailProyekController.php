<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyek;

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
}
