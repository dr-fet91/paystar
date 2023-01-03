<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(){
        return Inertia::render('Market/Product/Index', [
            'products' => Product::latest()->get(),
        ]);
    }

    public function view(Product $product){
        return Inertia::render('Market/Product/View', [
            'product' => $product,
        ]);
    }
}
