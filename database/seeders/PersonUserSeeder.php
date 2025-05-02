<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Api\PersonUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class PersonUserSeeder extends Seeder
{
    public function run(): void
    {
        PersonUser::insert([
            [
                'id_credential' => 1,
                'id_person'     => 1,
                'email'         => 'master@twoclicks.com.br',
                'password'      => Hash::make('123456'),
                'active'        => 1,
                'deleted'       => 0,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id_credential' => 2,
                'id_person'     => 2,
                'email'         => 'master@smartclick360.com',
                'password'      => Hash::make('123456'),
                'active'        => 1,
                'deleted'       => 0,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ]);
    }
}
