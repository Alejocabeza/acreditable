<?php

namespace App\Models;

use App\Traits\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserScope;

    protected $fillable = [
        'amount',
        'period',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
