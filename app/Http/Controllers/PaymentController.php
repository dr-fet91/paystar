<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function GuzzleHttp\Promise\all;

class PaymentController extends Controller
{
    public function payment(){
        $user = auth()->user();
        //dd(Order::where(['order_status' => 0, 'user_id' => $user->id])->latest()->get());
        return Inertia::render('Market/Product/Payment', [
            'order' => Order::where(['order_status' => 0, 'user_id' => $user->id])->latest()->first(),
        ]);
    }

    public function payment_submit(Request $request){
        switch ($request->payment) {
            case 'online':
                return redirect(route('online.payment', ['type' => 'online', 'gateway'=> $request->gateway]));
                break;
            
            default:
                # code...
                break;
        }
    }
}
