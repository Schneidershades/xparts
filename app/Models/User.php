<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Media;
use App\Models\Order;
use App\Models\Quote;
use App\Models\Wallet;
use App\Models\Address;
use App\Models\BankDetail;
use App\Models\XpartRequest;
use App\Models\WalletTransaction;
use Spatie\Permission\Traits\HasRoles;
use App\Models\XpartRequestVendorWatch;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\Auth\PasswordResetNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'api';

    public $oneItem = UserResource::class;
    public $allItems = UserCollection::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }

    public function orders()
    {
        return $this->hasMany(Order::class)->latest();
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function xpartRequestVendorWatch()
    {
        return $this->hasMany(XpartRequestVendorWatch::class, 'vendor_id')->latest();
    }
    
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function xpartRequests()
    {
        return $this->hasMany(XpartRequest::class)->latest();
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'vendor_id')->latest();
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function bankDetails()
    {
        return $this->hasMany(BankDetail::class);
    }

    public function avatar()
    {
        return $this->morphOne(Media::class, 'fileable');
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }
}
