<?php

namespace IBroStudio\PaymentMethodManager\Concerns;

use IBroStudio\PaymentMethodManager\Models\PaymentIntent;
use Lunar\Base\DataTransferObjects\PaymentAuthorize;
use Lunar\Base\DataTransferObjects\PaymentCapture;
use Lunar\Base\DataTransferObjects\PaymentChecks;
use Lunar\Base\DataTransferObjects\PaymentRefund;
use Lunar\Events\PaymentAttemptEvent;
use Lunar\Exceptions\Carts\CartException;
use Lunar\Exceptions\DisallowMultipleCartOrdersException;
use Lunar\Models\Cart;
use Lunar\Models\Order;
use Lunar\Models\Transaction;

trait CanManageCheckoutPayment
{
    /**
     * The instance of the cart.
     */
    protected ?Cart $cart = null;

    /**
     * The instance of the order.
     */
    protected ?Order $order = null;

    /**
     * Any config for this payment provider.
     */
    protected array $config = [];

    /**
     * Data storage.
     */
    protected array $data = [];

    /**
     * The Payment intent.
     */
    protected PaymentIntent $paymentIntent;

    /**
     * {@inheritDoc}
     */
    public function cart(Cart $cart): self
    {
        $this->cart = $cart;
        $this->order = null;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function order(Order $order): self
    {
        $this->order = $order;
        $this->cart = null;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function withData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setConfig(array $config): self
    {
        $this->config = $config;

        return $this;
    }

    public function getPaymentChecks(Transaction $transaction): PaymentChecks
    {
        return new PaymentChecks;
    }

    public function authorize(): ?PaymentAuthorize
    {
        $paymentIntentId = $this->data['payment_intent'];

        $intent = $this->intents()->where('intent_id', $paymentIntentId)->first();

        $this->order = $this->order ?: ($this->cart->draftOrder ?: $this->cart->completedOrder);

        if (($this->order && $this->order->placed_at) || $intent?->processing_at) {
            return null;
        }

        if (! $intent) {
            $intent = $this->intents()->create([
                'intent_id' => $paymentIntentId,
                'cart_id' => $this->cart?->id ?: $this->order->cart_id,
                'order_id' => $this->order?->id,
            ]);
        }

        $intent->update([
            'processing_at' => now(),
        ]);

        if (! $this->order) {
            try {
                $this->order = $this->cart->createOrder();
                $intent->order_id = $this->order->id;
            } catch (DisallowMultipleCartOrdersException | CartException $e) {
                $failure = new PaymentAuthorize(
                    success: false,
                    message: $e->getMessage(),
                    orderId: $this->order?->id,
                    paymentType: 'stripe'
                );

                PaymentAttemptEvent::dispatch($failure);

                return $failure;
            }
        }

        $this->paymentIntent = $this->stripe->paymentIntents->retrieve(
            $paymentIntentId
        );

        if (! $this->paymentIntent) {
            $failure = new PaymentAuthorize(
                success: false,
                message: 'Unable to locate payment intent',
                orderId: $this->order->id,
                paymentType: 'stripe',
            );

            PaymentAttemptEvent::dispatch($failure);

            return $failure;
        }
        /*
                if ($this->paymentIntent->status == PaymentIntent::STATUS_REQUIRES_CAPTURE && $this->policy == 'automatic') {
                    $this->paymentIntent = $this->stripe->paymentIntents->capture(
                        $this->data['payment_intent']
                    );
                }
        */
        $intent->status = $this->paymentIntent->status;

        /*
        $order = (new UpdateOrderFromIntent)->execute(
            $this->order,
            $this->paymentIntent
        );

        $response = new PaymentAuthorize(
            success: (bool) $order->placed_at,
            message: $this->paymentIntent->last_payment_error,
            orderId: $order->id,
            paymentType: 'stripe',
        );

        PaymentAttemptEvent::dispatch($response);

        $intent->processed_at = now();

        $intent->save();

        return $response;
        */
        return null;
    }

    public function refund(Transaction $transaction, int $amount, $notes = null): PaymentRefund
    {
        // TODO: Implement refund() method.
    }

    public function capture(Transaction $transaction, $amount = 0): PaymentCapture
    {
        // TODO: Implement capture() method.
    }
}
