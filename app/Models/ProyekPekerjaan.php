<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyekPekerjaan extends Model
{
    protected $table = 'proyek_pekerjaan';
    protected $appends = ['pendahuluan'];

    public function proyek()
    {
      return $this->belongsTo(Proyek::class, 'proyek_id');
    }

    public function pekerjaan()
    {
      return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }

    public function getPendahuluanAttribute()
    {
    	$str = $this->pekerjaan_sebelumnya;
      	$arr = (array)json_decode($str);
      	$data = $this->whereIn('id', $arr)->get();
      	$row = [];
      	foreach ($data as $key => $value) {
      		$row[] = $value->initial;
      	}

      	return implode(", ", $row);
    }
}
