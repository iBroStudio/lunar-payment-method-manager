<?php

namespace IBroStudio\PaymentMethodManager\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface MethodContract
{
    public function gateway(): BelongsTo;
}
