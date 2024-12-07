<?php

namespace IBroStudio\PaymentMethodManager\Concerns;

use IBroStudio\PaymentMethodManager\Models\CustomerMethod;
use IBroStudio\PaymentMethodManager\Models\Gateway;
use IBroStudio\PaymentMethodManager\Models\Method;

trait HasChildrenModels
{
    public function getChildModel(): static
    {
        if (in_array(get_parent_class($this), [Gateway::class, Method::class, CustomerMethod::class])) {
            return $this;
        }

        return $this->class::find($this->getKey());
    }
}
