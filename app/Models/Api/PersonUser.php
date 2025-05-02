<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PersonUser extends Model
{
    protected $table = 'person_user';

    protected $fillable = [
        'id_person',
        'email',
        'password',
        'active',
        'deleted',
    ];

    protected $hidden = [
        'password',
        'deleted',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public $timestamps = true;

    public function credential()
    {
        return $this->belongsTo(Credential::class, 'id_credential');
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'id_person');
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

        if (!request()->user()?->is_master) {
            unset($array['id_credential']);
        }

        return $array;
    }
}
