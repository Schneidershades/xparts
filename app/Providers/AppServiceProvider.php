<?php

namespace App\Providers;

use App\Models\Part;
use App\Models\User;
use App\Models\Quote;
use App\Models\Address;
use App\Models\XpartRequest;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
        
        Relation::morphMap([
            'quotes' => Quote::class,
            'addresses' => Address::class,
            'users' => User::class,
            'parts' => Part::class,
            'xpartRequests' => XpartRequest::class,
            'walletTransactions' => WalletTransaction::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
