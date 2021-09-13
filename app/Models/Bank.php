<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Bank\BankResource;
use App\Http\Resources\Bank\BankCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bank extends Model
{
    use HasFactory;

    public $oneItem = BankResource::class;
    public $allItems = BankCollection::class;
}
