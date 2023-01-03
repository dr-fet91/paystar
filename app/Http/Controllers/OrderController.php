<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class OrderController extends Controller
{
    public function Order(){
        $user = auth()->user();
        $carts = Cart::where('user_id', $user->id)->with('product')->get();
        $amount = 0;
        foreach ($carts as $cart) {
            $amount+= $cart->product->price;
        }
        try {
            Order::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'order_status' => 0,
                ],
                ['user_id' => $user->id, 'order_status' => 0, 'uuid' => Str::uuid(), 'amount' => $amount],
            );
            return redirect(route('payment'));
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('مشکلی در سفارش وجود دارد لطفا پس از بررسی اطلاعات مجدد تلاش نمایید.');
        }
        
    }
}
