<?php

namespace IBroStudio\PaymentMethodManager\Concerns;

use Filament\Forms;

trait HasCredentialsComponentsForm
{
    public function getCredentialsFormComponents(Forms\Form $form): Forms\Components\Component
    {
        /** @var string $dataClass */
        return $this->getChildModel()::$dataClass::getCredentialsFormComponents($form);
    }
}
