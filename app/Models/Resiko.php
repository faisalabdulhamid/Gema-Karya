<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resiko extends Model
{
    protected $table = 'resiko';

    protected $hidden = [
    	'created_at', 'updated_at'
    ];

    
}
