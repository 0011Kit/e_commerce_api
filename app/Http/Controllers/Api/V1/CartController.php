<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\PaymentCartMst;
use App\Models\PaymentCartDtl;
use App\Models\PaymentCartTrxn;
use App\Http\Resources\V1\PaymentCartResource;
use App\Models\Order;


class CartController extends Controller
{
     public function addToCart(Request $request){
        $request->validate([
            'productId' => 'required|exists:products,product_no',
            'quantity'  => 'required|integer|min:1',
        ]);

        $customer = $request->user(); // must be authenticated

        $product = Product::where('product_no', $request->productId)->firstOrFail();
        $sellerNo = $product->seller_no;

        $cart = PaymentCartMst::firstOrCreate(
            ['customer_no' => $customer->customer_no]
        );

        $trxn = PaymentCartTrxn::firstOrCreate(
            ['paycmst_no' => $cart->paycmst_no, 'seller_no' => $sellerNo]
        );

        $item = PaymentCartDtl::where('payctrxn_no', $trxn->payctrxn_no)
                              ->where('product_no', $product->product_no)
                              ->first();

        if ($item) {
            $item->paycdtl_selected_amt += $request->quantity;
            $item->save();
        } else {
            PaymentCartDtl::create([
                'payctrxn_no'          => $trxn->payctrxn_no,
                'product_no'           => $product->product_no,
                'paycdtl_selected_amt' => $request->quantity,
                'price'                => $product->product_unit_price, 
            ]);
        }

        return response()->json(['message' => 'Product [Name: '.$product->product_name.' - PID : '.$product->product_no.'] [Amt :'.$request->quantity.'] added to  '. $customer->customer_name . '\'s cart successfully']);
    }

    public function viewCart(Request $request){
        $customer = $request->user();

        $cart = PaymentCartMst::with([
            'transactions.items.product'
        ])
        ->where('customer_no', $customer->customer_no)
        ->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart is empty'], 200);
        }

        return new PaymentCartResource($cart);
    }

    public function removeTransaction(Request $request, $payctrxn_no){
        $customer = $request->user();

        $transaction = PaymentCartTrxn::where('payctrxn_no', $payctrxn_no)
            ->whereHas('cart', function ($q) use ($customer) {
                $q->where('customer_no', $customer->customer_no);
            })->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transaction->items()->delete();

        $transaction->delete();

        return response()->json(['message' => 'paycTrxn Id: '.$payctrxn_no.' removed from cart.']);
    }

    public function editCartItem(Request $request){
        $request->validate([
            'productId' => 'required|exists:products,product_no',
            'quantity'   => 'required|integer|min:1',
        ]);

        $customer = $request->user();
        $cart = PaymentCartMst::where('customer_no', $customer->customer_no)->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $cartTrxns = PaymentCartTrxn::where('paycmst_no', $cart->paycmst_no)->get();

        foreach ($cartTrxns as $trxn) {
            $item = PaymentCartDtl::where('payctrxn_no', $trxn->payctrxn_no)
                ->where('product_no', $request->productId)
                ->first();

            if ($item) {
                $item->paycdtl_selected_amt = $request->quantity;
                $item->save();

                return response()->json(['message' => 'Product Id: '.$request->productId. ' in PaymentCartTrxn :'.$trxn->payctrxn_no.' updated to '.$request->quantity.' successfully.']);
            }
        }

        return response()->json(['message' => 'Product not found in cart'], 404);
    }

    public function reviewOrder(Request $request){
        $customer = $request->user();

        $orders = Order::with(['orderItems.product'])
            ->where('customer_no', $customer->customer_no)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['data' => $orders]);
    }

}

