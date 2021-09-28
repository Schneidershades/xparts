<?php

namespace Database\Seeders;

use App\Models\PaymentCharge;
use Illuminate\Database\Seeder;

class PaymentChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentCharge::Create([
            'gateway'                               => 'paystack',
            'type'                                  => 'percentage',
            'percentage_gateway_charge'             => 1.5,
            'percentage_company_charge'             => 0.5,
            'amount_gateway_charge'                 => 100,
            'amount_company_charge'                 => 0,
            'currency'                              => 'Naira',
            'currency_symbol'                       => 'N',
        ]);

        PaymentCharge::Create([
            'gateway'                               => 'wallet',
            'type'                                  => 'percentage',
            'percentage_gateway_charge'             => 0,
            'percentage_company_charge'             => 0.5,
            'amount_gateway_charge'                 => 0,
            'amount_company_charge'                 => 0,
            'currency'                              => 'Naira',
            'currency_symbol'                       => 'N',
        ]);
    }
}