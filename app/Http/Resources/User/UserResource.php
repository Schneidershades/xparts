<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Cart\CartResource;
use App\Http\Resources\User\WalletResource;
use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Bank\BankDetailResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,

            'phone' => $this->phone,

            'role' => $this->getRoleNames(),
            
            'verified' => $this->email_verified_at ? true : false,
            'addresses' => AddressResource::collection($this->addresses),
            
            'wallet' => new WalletResource($this->wallet),
            
            'permissions' => $this->getPermissionsViaRoles()->pluck('name')->map(function($permission){
                return explode('_', $permission);
            })->toArray(),

            $this->mergeWhen(auth()->user()->id == $this->id && auth()->user()->role == 'user', [
                'cart' => CartResource::collection($this->cart),
            ]),

            $this->mergeWhen(auth()->user()->id == $this->id && auth()->user()->role == 'vendor', [
                'bankDetails' => BankDetailResource::collection($this->bankDetails),
            ]),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
