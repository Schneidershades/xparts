<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Api\QueryFieldSearchScope;

class Wallet extends Model
{
    use HasFactory, QueryFieldSearchScope;

    protected $fillable = [
        "balance",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
