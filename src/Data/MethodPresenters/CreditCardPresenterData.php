<?php

namespace IBroStudio\PaymentMethodManager\Data\MethodPresenters;

use DateTime;
use IBroStudio\PaymentMethodManager\Contracts\MethodPresenterDataContract;
use Spatie\LaravelData\Data;

class CreditCardPresenterData extends Data implements MethodPresenterDataContract
{
    public function __construct(
        public string $number,
        public string $provider,
        public DateTime $expires_at,
    ) {}

    public function asOptionDescription(): string
    {
        return __('lunar-payment-method-manager::translations.method-presenters.credit-card.asOption', [
            'number' => $this->number,
        ]);
    }
}
