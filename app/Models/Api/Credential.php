<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    protected $table = 'credential';

    protected $fillable = [
        'username',
        'is_master',
        'active',
        'deleted',
        'dt_expiration',
        'dt_limit_access',
    ];

    protected $hidden = [
        'deleted',
    ];

    protected $casts = [
        'created_at'      => 'datetime:Y-m-d H:i:s',
        'updated_at'      => 'datetime:Y-m-d H:i:s',
        'dt_expiration'   => 'datetime:Y-m-d H:i:s',
        'dt_limit_access' => 'datetime:Y-m-d H:i:s',
    ];

    public $timestamps = true;

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->timezone('America/Sao_Paulo')->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->timezone('America/Sao_Paulo')->format('Y-m-d H:i:s');
    }
}
