<?php

namespace IBroStudio\PaymentMethodManager\Database\Factories;

use IBroStudio\PaymentMethodManager\Models\Gateway;
use IBroStudio\PaymentMethodManager\Models\Method;
use Illuminate\Database\Eloquent\Factories\Factory;

class MethodFactory extends Factory
{
    protected $model = Method::class;

    public function definition()
    {
        return [
            'gateway_id' => Gateway::factory(),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'icon' => 'lucide-credit-card',
            'enabled' => 1,
        ];
    }
}
