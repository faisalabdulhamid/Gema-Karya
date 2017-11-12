<?php

namespace App\Models\Utilities;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait ModelHepler
{
  public function CreatedBy()
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  public function UpdatedBy()
  {
    return $this->belongsTo(User::class, 'updated_by');
  }

  public function dibuat()
  {
    return (!is_null($this->CreatedBy)) ? $this->CreatedBy->nama: '';
  }

  public function diubah()
  {
    return (!is_null($this->UpdatedBy)) ? $this->UpdatedBy->nama: '';
  }

  protected static function boot()
  {
      parent::boot();

      static::saved(function($save){
        // $save->created_by = Auth::user()->id;
      });

      static::updated(function($update){
        // $update->updated_by = Auth::user()->id;
      });
  }
}
