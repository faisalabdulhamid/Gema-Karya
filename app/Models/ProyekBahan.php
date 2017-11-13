<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyekBahan extends Model
{
  protected $table = 'proyek_bahan';

  public function proyek()
  {
    return $this->belongsTo(Proyek::class, 'proyek_id');
  }

  public function bahan()
  {
    return $this->belongsTo(BahanBaku::class, 'bahan_id');
  }
}
