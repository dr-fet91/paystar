<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OnlinePaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\OnlinePayment;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$user = User::where('id', 1)->first();
if(!$user){
    (new DatabaseSeeder)->run();
    $user = User::where('id', 1)->first();
}

Auth::login($user);

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::get('/', [ProductController::class, 'index']);
Route::prefix('product')->group(function(){
    Route::get('view/{product:slug}', [ProductController::class, 'view'])->name('product.view');
});
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('checkout')->group(function(){
        Route::get('cart', [CartController::class, 'Cart'])->name('cart');
        Route::post('add_to_cart', [CartController::class, 'addToCart'])->name('add_to_cart');
        Route::post('order', [OrderController::class, 'order'])->name('order');
        Route::get('payment', [PaymentController::class, 'payment'])->name('payment');
        Route::post('payment', [PaymentController::class, 'payment_submit'])->name('payment_submit');
        Route::prefix('payment')->group(function(){
            Route::prefix('online')->group(function(){
                Route::get('/', [OnlinePaymentController::class, 'pay'])->name('online.payment');
                Route::get('/final-approval', [OnlinePaymentController::class, 'finalApproval'])->name('online.payment.final-approval');
            });
        });
    });
});

Route::get('/callback', [OnlinePaymentController::class, 'callBack'])->name('callBack');


require __DIR__.'/auth.php';
