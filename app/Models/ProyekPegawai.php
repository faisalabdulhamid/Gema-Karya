<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyekPegawai extends Model
{
  protected $table = 'proyek_pegawai';

  public function proyek()
  {
    return $this->belongsTo(Proyek::class, 'proyek_id');
  }

  public function pegawai()
  {
    return $this->belongsTo(Pegawai::class, 'pegawai_id');
  }
}
