<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Api\Credential;
use Illuminate\Support\Carbon;

class CredentialSeeder extends Seeder
{
    public function run(): void
    {
        Credential::insert([
            [
                'username'        => 'TwoClicks',
                'is_master'       => 1,
                'active'          => 1,
                'deleted'         => 0,
                'dt_expiration'   => '2027-12-31',
                'dt_limit_access' => '2028-12-31',
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now(),
            ],
            [
                'username'        => 'SmartClick360',
                'is_master'       => 1,
                'active'          => 1,
                'deleted'         => 0,
                'dt_expiration'   => '2027-12-31',
                'dt_limit_access' => '2028-12-31',
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now(),
            ]
        ]);
    }
}
