<?php

namespace App\Http\Resources\User;

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
            
            $this->mergeWhen(auth()->user()->id == $this->id, [
                'verified' => $this->email_verified_at ? true : false,
                'role' => $this->role,
                'permissions' => $this->getPermissionsViaRoles()->pluck('name')->map(function($permission){
                    return explode('_', $permission);
                })->toArray(),
                'wallet' => new WalletResource($this->wallet),
            ]),
            
        ];
    }
}
