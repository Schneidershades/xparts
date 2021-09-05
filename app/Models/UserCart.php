<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\User\UserCartResource;
use App\Http\Resources\User\UserCartCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCart extends Model
{
    use HasFactory;
    
    public $oneItem = UserCartResource::class;
    public $allItems = UserCartCollection::class;

    public function cartable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
