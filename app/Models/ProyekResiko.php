<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyekResiko extends Model
{
  protected $table = 'proyek_resiko';

  protected $hidden = [
  	'created_at', 'updated_at', 'proyek_id'
  ];

  protected $appends = ['nama_resiko'];

  public function proyek()
  {
    return $this->belongsTo(Proyek::class, 'proyek_id');
  }

  public function resiko()
  {
    return $this->belongsTo(Resiko::class, 'resiko_id');
  }

  public function getNamaResikoAttribute()
  {
  	return $this->resiko()->first()->resiko;
  }
}
