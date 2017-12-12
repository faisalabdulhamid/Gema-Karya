<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyekPekerjaan extends Model
{
    protected $table = 'proyek_pekerjaan';
    
    protected $hidden = [
      'created_at', 'updated_at', 'proyek_id', 'pivot', 'pekerjaan_id'
    ];

    protected $appends = ['nama_pekerjaan'];

    public function proyek()
    {
      return $this->belongsTo(Proyek::class, 'proyek_id');
    }

    public function pekerjaan()
    {
      return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }

    public function pendahulu()
    {
      return $this->belongsToMany(ProyekPekerjaan::class, 'proyek_pekerjaan_detail', 'proyek_pekerjaan_id', 'proyek_pekerjaan_sebelumnya');
    }

    public function penerus()
    {
      return $this->belongsToMany(ProyekPekerjaan::class, 'proyek_pekerjaan_detail', 'proyek_pekerjaan_sebelumnya', 'proyek_pekerjaan_id');
    }

    public function getNamaPekerjaanAttribute()
    {
      return (!is_null($this->pekerjaan()->first()))? $this->pekerjaan()->first()->pekerjaan: '';
    }
}
