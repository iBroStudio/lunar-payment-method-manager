<?php

namespace IBroStudio\PaymentMethodManager\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface MethodContract
{
    public static function bootHasClassProperty();

    public function gateway(): BelongsTo;
}
