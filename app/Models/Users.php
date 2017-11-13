<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Utilities\InterfaceModel;
use App\Models\Utilities\ModelHepler;
use Illuminate\Database\Eloquent\Builder;

class Users extends Authenticatable implements InterfaceModel
{
    use Notifiable, ModelHepler;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user', function (Builder $builder) {
            $builder->where('status', '=', 'direktur')
              ->orWhere('status', '=', 'teknisi');
        });
    }
}
