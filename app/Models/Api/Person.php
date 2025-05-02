<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Person extends Model
{
    protected $table = 'person';

    protected $fillable = [
        'name',
        'birthdate',
        'active',
        'deleted',
    ];

    protected $hidden = [
        'deleted',
    ];

    protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at'  => 'datetime:Y-m-d H:i:s',
        'birthdate'   => 'date:Y-m-d',
    ];

    public $timestamps = true;

    public function credential()
    {
        return $this->belongsTo(Credential::class, 'id_credential');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('America/Sao_Paulo')->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('America/Sao_Paulo')->format('Y-m-d H:i:s');
    }

    public function toArray(): array
    {
        $array = parent::toArray();

        $array['created_at'] = $this->getCreatedAtAttribute($this->attributes['created_at']);
        $array['updated_at'] = $this->getUpdatedAtAttribute($this->attributes['updated_at']);

        // Oculta id_credential se não for master
        if (!request()->user()?->is_master) {
            unset($array['id_credential']);
        }

        return $array;
    }
}
