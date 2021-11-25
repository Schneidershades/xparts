<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\User\FcmPushSubscriptionResource;
use App\Http\Resources\User\FcmPushSubscriptionCollection;

class FcmPushSubscription extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public $oneItem = FcmPushSubscriptionResource::class;
    public $allItems = FcmPushSubscriptionCollection::class;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
