<?php

namespace IBroStudio\PaymentMethodManager\Components;

use IBroStudio\GoCardless\Components\GoCardlessPaymentForm;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Cart;

class PaymentMethodLoader extends Component
{
    public ?Cart $cart;

    #[Reactive]
    public ?int $payment_method_id;

    public Collection $paymentMethods;

    public function mount()
    {
        $this->cart = CartSession::current();

//        $this->paymentMethods = PaymentMethod::getPaymentMethods($this->cart);

        $this->paymentMethods = collect([
            1 => GoCardlessPaymentForm::class,
            2 => GoCardlessPaymentForm::class,
        ]);
    }

    #[Computed]
    public function component()
    {
        $this->cart->update([
            'meta' => ['payment_method_id' => $this->payment_method_id],
        ]);

        return $this->paymentMethods->get($this->payment_method_id);
    }

    public function render()
    {
        return view('lunar-payment-method-manager::components.payment-method-loader');
    }
}
