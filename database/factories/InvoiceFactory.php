<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => 1,
            'invoice_no' => $this->faker->randomNumber(6),
            'receive_no' => $this->faker->randomNumber(6),
            'invoice_date' => $this->faker->date(),
        ];
    }
}
