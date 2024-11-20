<?php

namespace IBroStudio\PaymentMethodManager\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PaymentMethodStatesEnum: string implements HasColor, HasLabel
{
    case ACTIVE = 'active';
    case BLOCKED = 'blocked';
    case CANCELED = 'canceled';
    case EXPIRED = 'expired';
    case FAILED = 'failed';
    case PENDING = 'pending';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ACTIVE => 'active',
            self::BLOCKED => 'started',
            self::CANCELED => 'processing',
            self::EXPIRED => 'waiting',
            self::FAILED => 'failed',
            self::PENDING => 'pending',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::BLOCKED => 'warning',
            self::CANCELED => 'danger',
            self::EXPIRED => 'warning',
            self::FAILED => 'danger',
            self::PENDING => 'info',
        };
    }
}
