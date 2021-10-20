<?php

namespace Database\Seeders;

use App\Models\Quote;
use App\Models\XpartRequest;
use Illuminate\Database\Seeder;
use App\Models\WalletTransaction;
use App\Models\XpartRequestVendorWatch;

class TruncateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Quote::truncate();
        XpartRequest::truncate();
        XpartRequestVendorWatch::truncate();
        WalletTransaction::truncate();
    }
}
