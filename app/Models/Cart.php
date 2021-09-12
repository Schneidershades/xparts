<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Cart\CartResource;
use App\Http\Resources\Cart\CartCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'cartable_type',
        'cartable_id',
        'quantity',
    ];
    
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
