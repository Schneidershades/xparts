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

    protected $guarded = [];

    public $oneItem = BankDetailResource::class;
    public $allItems = BankDetailCollection::class;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
