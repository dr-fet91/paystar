<?php

namespace App\Listeners;

use App\Events\UpdateOnlinePayment;
use App\Models\Cart;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CompletionOrder
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UpdateOnlinePayment  $event
     * @return void
     */
    public function handle(UpdateOnlinePayment $event)
    {
        try {
            $onlinePayment = $event->onlinePayment;
            if ($onlinePayment->status != 3) {
                 return;
            }
            $user = auth()->user();
            $order = $onlinePayment->order;
            $carts = Cart::where('user_id', $user->id)->with('product')->get();
            foreach ($carts as $cart) {
                OrderItem::create(
                    [
                        'user_id' => $user->id,
                        'order_id' => $order->id,
                        'product_id' => $cart->product->id,
                    ]
                );
                $cart->delete();
            }
            $payment = Payment::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'amount' => $order->amount,
                'status' => 3,
                'type' => 0,
                'paymentable_id' => $onlinePayment->id,
                'paymentable_type' => get_class($onlinePayment),
            ]);

            $order->update([
                'payment_id' => $payment->id,
                'payment_object' => json_encode($payment),
                'payment_object' => json_encode($payment),
                'payment_type' => 0,
                'payment_status' => 3,
                'order_status' => 3,
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
