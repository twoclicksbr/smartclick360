<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Api\Token;
use Carbon\Carbon;

class ClearExpiredTokens extends Command
{
    protected $signature = 'tokens:clear-expired';
    protected $description = 'Remove tokens expirados da base';

    public function handle()
    {
        $count = Token::where('expires_at', '<', Carbon::now())->delete();
        $this->info("Tokens removidos: {$count}");
    }
}
