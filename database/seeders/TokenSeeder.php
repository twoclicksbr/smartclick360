<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Api\Token;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class TokenSeeder extends Seeder
{
    public function run(): void
    {
        Token::insert([
            [
                'id_credential' => 1,
                'id_person'     => 1,
                'token'         => hash('sha256', Str::uuid()),
                'expires_at'    => Carbon::now()->addDays(365),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id_credential' => 2,
                'id_person'     => 2,
                'token'         => hash('sha256', Str::uuid()),
                'expires_at'    => Carbon::now()->addDays(365),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ]);
    }
}
