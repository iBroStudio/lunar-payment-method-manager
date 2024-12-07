<?php

namespace IBroStudio\PaymentMethodManager\Actions;

use IBroStudio\PaymentMethodManager\Models\Gateway;
use Lorisleiva\Actions\Concerns\AsAction;

class ValidateGatewayCredentials
{
    use AsAction;

    public function handle(
        array $credentialsData,
        Gateway $gateway
    ): bool {
        return $gateway
            ->api()
            ->validateCredentials($credentialsData);
    }
}
