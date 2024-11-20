<?php

use IBroStudio\PaymentMethodManager\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

pest()->printer()->compact();

pest()
    ->extends(
        TestCase::class,
        RefreshDatabase::class,
    )
    ->in(__DIR__);
