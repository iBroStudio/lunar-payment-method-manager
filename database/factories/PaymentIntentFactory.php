<?php

namespace IBroStudio\PaymentMethodManager\Database\Factories;

use IBroStudio\PaymentMethodManager\Models\PaymentIntent;
use IBroStudio\TestSupport\Models\FakePaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Lunar\Models\Cart;
use Lunar\Models\Order;

class PaymentIntentFactory extends Factory
{
    protected $model = PaymentIntent::class;

    public function definition(): array
    {
        return [
            'gateway_intent_id' => $this->faker->word(),
            'status' => $this->faker->word(),
            'event_id' => $this->faker->word(),
            'processing_at' => Carbon::now(),
            'processed_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'cart_id' => Cart::factory(),
            'order_id' => Order::factory(),
            'method_id' => FakePaymentMethod::factory(),
        ];
    }
}
