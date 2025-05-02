<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Api\Person;
use Illuminate\Support\Carbon;

class PersonSeeder extends Seeder
{
    public function run(): void
    {
        Person::insert([
            [
                'id_credential' => 1,
                'name'          => 'Alex - TwoClicks',
                'birthdate'     => '1990-01-01',
                'active'        => 1,
                'deleted'       => 0,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id_credential' => 2,
                'name'          => 'SmartClick360 - Site',
                'birthdate'     => '1997-05-09',
                'active'        => 1,
                'deleted'       => 0,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ]);
    }
}
