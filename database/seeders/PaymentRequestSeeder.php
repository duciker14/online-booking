<?php

namespace Database\Seeders;

use App\Models\PaymentRequest;
use Illuminate\Database\Seeder;

class PaymentRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentRequest::factory(20)->create();
    }
}
