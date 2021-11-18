<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Cart\CartResource;
use App\Http\Resources\Cart\CartCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Api\QueryFieldSearchScope;

class Cart extends Model
{
    use HasFactory, QueryFieldSearchScope;

    protected $fillable = [
        'cartable_type',
        'cartable_id',
        'quantity',
    ];
    public $searchables = [];
    
    public $oneItem = CartResource::class;
    public $allItems = CartCollection::class;

    public function cartable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
