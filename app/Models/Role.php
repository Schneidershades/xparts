<?php

namespace App\Models;

use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\Role\RoleCollection;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends SpatieRole
{
    use HasFactory;

    public $oneItem = RoleResource::class;
    public $allItems = RoleCollection::class;
}
