<?php

namespace IBroStudio\PaymentMethodManager\Components;

use IBroStudio\PaymentMethodManager\Models\Method;
use Livewire\Component;
use Lunar\Models\Cart;

abstract class PaymentForm extends Component
{
    public Cart $cart;

    protected Method $method;

    public string $returnUrl;

    public function mount()
    {
        $this->method = Method::find($this->cart->meta['payment_method_id']);

        $this->method->getIntent($this->cart);

        dd($this->cart->meta['payment_method_id']);
        dd($this->cart);
    }
}
