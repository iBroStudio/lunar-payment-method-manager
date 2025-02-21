<?php

use IBroStudio\PaymentMethodManager\Enums\PaymentMethodStatesEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Lunar\Models\Customer;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('class');
            $table->unsignedBigInteger('credentials')->nullable();
        });

        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('class');
            $table->foreignId('gateway_id')->constrained('payment_gateways')->onDelete('cascade');
            $table->json('description')->nullable();
            $table->string('icon');
            $table->foreignIdFor(Customer::class)->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('credentials')->nullable();
            $table->string('state')->nullable();
            $table->unsignedTinyInteger('default')->default(0);
            $table->unsignedTinyInteger('enabled')->default(0);
            $table->timestamps();
        });
    }
};
