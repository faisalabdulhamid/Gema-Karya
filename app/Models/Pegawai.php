<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Pegawai extends Model
{
    protected $table = 'users';
    
    protected $hidden = [
    	'created_at', 'updated_at', 'email', 'username', 'password', 'status', 'remember_token'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('pegawai', function (Builder $builder) {
            $builder->where('status', '=', 'pegawai');
        });
    }
}
