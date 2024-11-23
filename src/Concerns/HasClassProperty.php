<?php

namespace IBroStudio\PaymentMethodManager\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait HasClassProperty
{
    public static function bootHasClassProperty()
    {
        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('class', get_called_class());
        });

        static::creating(function (Model $method) {
            $method->class = get_called_class();
        });
    }
}
