<?php

namespace IBroStudio\PaymentMethodManager\Concerns;

use Filament\Forms;

trait HasCredentialsComponentsForm
{
    public function getCredentialsFormComponents(Forms\Form $form): Forms\Components\Component
    {
        return $this->class::{static::$dataClass}::getCredentialsFormComponents($form);
    }
}
