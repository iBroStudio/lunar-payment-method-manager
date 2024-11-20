<?php

namespace IBroStudio\PaymentMethodManager\Database\Factories;

use IBroStudio\PaymentMethodManager\Enums\PaymentMethodStatesEnum;
use IBroStudio\PaymentMethodManager\Models\CustomerMethod;
use IBroStudio\PaymentMethodManager\Models\Method;
use Illuminate\Database\Eloquent\Factories\Factory;
use Lunar\Models\Customer;

class CustomerMethodFactory extends Factory
{
    protected $model = CustomerMethod::class;

    public function definition()
    {
        return [
            'method_id' => Method::factory(),
            'customer_id' => Customer::factory(),
            'state' => $this->faker->randomElement(PaymentMethodStatesEnum::cases()),
        ];
    }
}
