<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::Create([
            'name'             => 'Card',
            'payment_gateway'  => 'paystack'
        ]);

        PaymentMethod::Create([
            'name'             => 'Wallet',
            'payment_gateway'  => 'wallet'
        ]);

        PaymentMethod::Create([
            'name'             => 'Payment on Delivery',
        ]);

    }
}
