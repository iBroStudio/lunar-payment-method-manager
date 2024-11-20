<?php

namespace IBroStudio\PaymentMethodManager\Database\Factories;

use IBroStudio\PaymentMethodManager\Models\Gateway;
use Illuminate\Database\Eloquent\Factories\Factory;

class GatewayFactory extends Factory
{
    protected $model = Gateway::class;

    public function definition(): array
    {
        return [
            'class' => $this->faker->word(),
            'name' => $this->faker->word(),
            'icon' => 'lucide-circle-dollar-sign',
        ];
    }
}
