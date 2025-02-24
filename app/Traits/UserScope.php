<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

trait UserScope
{
    public static function bootUserScope()
    {
        static::creating(function ($model) {
            if (empty($model->user_id)) {
                $model->user_id = Auth::id();
            }
        });

        static::addGlobalScope(function (Builder $builder) {
            $builder->where('user_id', Auth::id());
        });
    }
}
