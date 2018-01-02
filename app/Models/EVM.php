<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EVM extends Model
{
    protected $table = 'evm';
    protected $fillable = [
		'minggu_ke',
		'bcws_bobot',
		'bcws_budget',
		'proyek_id',
    ];
}
