<?php

namespace App\Models;

use App\Traits\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserScope;

    protected $fillable = [
        'amount',
        'date',
        'account_id',
        'description'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
