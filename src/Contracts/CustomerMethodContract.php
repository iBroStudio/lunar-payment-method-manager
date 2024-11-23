<?php

namespace IBroStudio\PaymentMethodManager\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface CustomerMethodContract
{
    public static function bootHasClassProperty();

    public function method(): BelongsTo;
}
