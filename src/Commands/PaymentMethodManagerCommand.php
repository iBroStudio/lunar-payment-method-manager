<?php

namespace IBroStudio\PaymentMethodManager\Commands;

use Illuminate\Console\Command;

class PaymentMethodManagerCommand extends Command
{
    public $signature = 'lunar-payment-method-manager';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
