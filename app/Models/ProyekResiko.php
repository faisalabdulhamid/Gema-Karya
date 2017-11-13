<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyekResiko extends Model
{
  protected $table = 'proyek_resiko';

  public function proyek()
  {
    return $this->belongsTo(Proyek::class, 'proyek_id');
  }

  public function resiko()
  {
    return $this->belongsTo(Resiko::class, 'resiko_id');
  }
}
