<?php

namespace App\Models;

use App\Traits\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;
    use HasFactory;
    use UserScope;

    protected $fillable = [
        'name',
        'initial_date',
        'type',
        'balance'
    ];

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
}
