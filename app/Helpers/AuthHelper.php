<?php

namespace App\Helpers;

class AuthHelper
{
    public static function denyIfNotOwnerOrMaster($model): void
    {
        if (!request()->user()?->is_master && $model->id_credential !== request('id_credential')) {
            abort(403, 'Acesso negado.');
        }
    }
}
