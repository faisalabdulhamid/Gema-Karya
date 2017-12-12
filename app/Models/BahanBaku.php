<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    protected $table = 'bahan_baku';
    
    protected $hidden = [
    	'created_at', 'updated_at'
    ];
}
