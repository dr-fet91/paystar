<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
class CartController extends Controller
{
    public function cart()
    {
        $user = auth()->user();
        // Eager loading
        $carts = Cart::where('user_id', $user->id)->with('product')->get();
        if($user && $carts){
            return Inertia::render('Market/Product/Cart', [
                'carts' => $carts,
            ]);
        }
        
    }

    // add and update cart
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'numeric|exists:products,id',
            'number' => 'numeric|min:1',
        ]);
        try {
            $request->user()->carts()->updateOrCreate(['product_id' => $request->product_id], ['number' => $request->number]);
            return redirect(route('cart'));
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('مشکلی در سفارش وجود دارد لطفا پس از بررسی اطلاعات مجدد تلاش نمایید.');
        }
    }
}
