<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Bank;
use App\Models\BankDetail;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class EloquentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Relation::morphMap([
            'Address' => Address::class,
            'Bank' => Bank::class,
            'BankDetails' => BankDetail::class,
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
