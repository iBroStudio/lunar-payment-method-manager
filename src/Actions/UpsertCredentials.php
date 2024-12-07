<?php

namespace IBroStudio\PaymentMethodManager\Actions;

use Illuminate\Database\Eloquent\Model;
use Lorisleiva\Actions\Concerns\AsAction;

class UpsertCredentials
{
    use AsAction;

    public function handle(
        array $credentialsData,
        Model $model
    ): bool {
        $child = $model->getChildModel();

        $child->credentials = $credentialsData;

        return $child->save();
    }
}
