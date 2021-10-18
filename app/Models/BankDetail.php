<?php

namespace App\Models;

use App\Models\User;
use App\Models\Bank;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Bank\BankDetailResource;
use App\Http\Resources\Bank\BankDetailCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankDetail extends Model
{
    use HasFactory;

    public $oneItem = BankDetailResource::class;
    public $allItems = BankDetailCollection::class;

    public function user()
    {
        return $this->belongTo(User::class);
    }

    public function bank()
    {
        return $this->belongTo(Bank::class);
    }
}
