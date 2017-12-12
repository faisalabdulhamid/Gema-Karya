<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    protected $table = 'proyek';
    protected $appends = ['url_show'];

    protected $hidden = [
    	'created_at', 'updated_at'
    ];
    
    public function getUrlShowAttribute()
    {
      return route('detail.index', ['param'=>$this->id]);
    }
}
