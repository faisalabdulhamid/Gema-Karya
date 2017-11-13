<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyekPekerjaan extends Model
{
    protected $table = 'proyek_pekerjaan';

    public function proyek()
    {
      return $this->belongsTo(Proyek::class, 'proyek_id');
    }

    public function pekerjaan()
    {
      return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }
}
