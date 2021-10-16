<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory()
            ->count(50)
            ->has(
                Invoice::factory()
                    ->count(3)
                    ->has(
                        InvoiceItem::factory()
                            ->count(2)
                    )
            )
            ->create();
    }
}
