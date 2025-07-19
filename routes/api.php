<?php

use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\PaymentCartDtlController;
use App\Http\Controllers\Api\V1\PaymentCartMstController;
use App\Http\Controllers\Api\V1\PaymentCartTrxnController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\SellerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\PaymentCartDtl;
use App\Models\Seller;
use App\Http\Controllers\Api\V1\CartController;


Route::middleware('auth:sanctum')->get('/test', function () {
    return ['message' => 'Hello from Sanctum!'];
});

Route::post('/customer/test', function (Request $request) {
    return $request->email . " " . $request->password;
});

Route::put('test-route', function () {
    return 'PUT works';
});


//20250705/version 1
Route::prefix('v1')->group(function () {
    // Public Resources
    Route::apiResource('product', ProductController::class)->only(['index', 'show']);

    // Protected Resources
    Route::middleware('auth:sanctum')->group(function () {
        //custom route
        //cart 
        Route::post('cart/addToCart', [CartController::class, 'addToCart']);
        Route::get('cart/viewCart', [CartController::class, 'viewCart']);
        Route::delete('cart/remove-trxn/{payctrxn_no}', [CartController::class, 'removeTransaction']);
        Route::put('cart/edit', [CartController::class, 'editCartItem']);

        //order        
        Route::get('order/history', [OrderController::class, 'reviewOrderList']); 
        Route::post('order/fromcart', [OrderController::class, 'orderFromCart']); 
        Route::post('order/now', [OrderController::class, 'orderNow']); 
        Route::post('order/cancel', [OrderController::class, 'cancelOrder']);


        //general route
        Route::apiResource('customer', CustomerController::class);
        Route::apiResource('seller', SellerController::class);
        Route::apiResource('order', OrderController::class);
        Route::apiResource('paymentcartmst', PaymentCartMstController::class);
        Route::apiResource('paymentcartdtl', PaymentCartDtlController::class);
        Route::apiResource('paymentcarttrxn', PaymentCartTrxnController::class);
    });
});


// General Functions Start //
Route::post('/customer/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $customer = Customer::where('customer_email', $request->email)->first();

    if (! $customer || ! Hash::check($request->password, $customer->customer_password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $customer->createToken('customer-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'customer' => $customer,
    ]);
})->name('login');


Route::middleware('auth:customer')->get('customer/viewProfile', function (Request $request) {
    return $request->user('customer'); 
});

// General Functions End //

