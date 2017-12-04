<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    protected $table = 'proyek';
    protected $appends = ['url_show'];

    public function getUrlShowAttribute()
    {
      return route('detail', ['param'=>$this->id]);
    }
}
