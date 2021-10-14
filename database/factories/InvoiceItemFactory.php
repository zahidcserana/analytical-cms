<?php

namespace Database\Factories;

use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $length = $this->faker->numberBetween(10, 30);
        $width = $this->faker->numberBetween(10, 30);
        $quantity = $this->faker->numberBetween(1, 10);
        $price = $this->faker->numberBetween(1, 5);

        return [
            'invoice_id' => 1,
            'buyer' => $this->faker->name(),
            'style' => $this->faker->company(),
            'color' => $this->faker->colorName(),
            'length' => $length,
            'width' => $width,
            'quantity' => $quantity,
            'price' => $price,
            'area' => $length * $width,
            'amount' => $length * $width * $quantity * $price,
        ];
    }
}
