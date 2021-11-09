<?php

namespace App\Models;

use App\Models\User;
use App\Models\Bank;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Bank\BankDetailResource;
use App\Http\Resources\Bank\BankDetailCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Api\QueryFieldSearchScope;

class BankDetail extends Model
{
    use HasFactory, QueryFieldSearchScope;

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
