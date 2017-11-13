<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Pegawai extends Model
{
    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('pegawai', function (Builder $builder) {
            $builder->where('status', '=', 'pegawai');
        });
    }
}
