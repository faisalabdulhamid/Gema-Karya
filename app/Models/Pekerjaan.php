<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    protected $table = 'pekerjaan';
    
    protected $hidden = [
    	'created_at', 'updated_at'
    ];
}
