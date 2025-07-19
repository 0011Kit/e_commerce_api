<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\V1\OrderResource;
use App\Http\Resources\V1\OrderCollection;
use App\Filters\V1\OrderFilter;
use Illuminate\Http\Request;
use App\Models\PaymentCartTrxn;
use App\Models\PaymentCartDtl;
use App\Models\OrderItem;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index(Request $request)
    {
        $filter = new OrderFilter();
        $queryItems = $filter->transform($request);

        $order = count($queryItems)
            ? Order::where($queryItems)->paginate()
            : Order::paginate();

        return new OrderCollection($order);
    }

    public function reviewOrderList(Request $request){
        $customer = $request->user();

        $orders = Order::with(['orderItems.product'])
            ->where('customer_no', $customer->customer_no)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['data' => $orders]);
    }

   public function orderFromCart(Request $request){
        $request->validate([
            'payctrxn_nos' => 'required|array',
            'payctrxn_nos.*' => 'exists:payment_cart_trxns,payctrxn_no',
        ]);

        $customer = $request->user();
        $trxns = PaymentCartTrxn::whereIn('payctrxn_no', $request->payctrxn_nos)
            ->whereHas('cart', function ($q) use ($customer) {
                $q->where('customer_no', $customer->customer_no);
            })
            ->get();

        if ($trxns->count() !== count($request->payctrxn_nos)) {
            return response()->json(['message' => 'Some transactions not found'], 404);
        }

        $items = collect();
        $grandTotal = 0;

        foreach ($trxns as $trxn) {
            $trxnItems = PaymentCartDtl::where('payctrxn_no', $trxn->payctrxn_no)->get();
            foreach ($trxnItems as $item) {
                $product = $item->product; 
                $subtotal = $item->paycdtl_selected_amt * $product->product_unit_price;

                $items->push([
                    'product_no' => $item->product_no,
                    'seller_no' => $trxn->seller_no,
                    'quantity' => $item->paycdtl_selected_amt,
                    'unit_price' => $product->product_unit_price,
                    'subtotal' => $subtotal,
                ]);

                $grandTotal += $subtotal;
            }
        }

        if ($items->isEmpty()) {
            return response()->json(['message' => 'No items found in given transactions'], 400);
        }

        if ($customer->customer_balance < $grandTotal) {
            return response()->json(['message' => 'Insufficient balance'], 400);
        }

        // Create order
        $order = Order::create([
            'order_status' => 'D',
            'order_grand_total' => $grandTotal,
            'payment_date' => now(),
            'customer_no' => $customer->customer_no
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_no' => $order->order_no,
                'product_no' => $item['product_no'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        // Deduct balance
        $customer->customer_balance -= $grandTotal;
        $customer->save();

        // delete cart items
        PaymentCartDtl::whereIn('payctrxn_no', $request->payctrxn_nos)->delete();
        PaymentCartTrxn::whereIn('payctrxn_no', $request->payctrxn_nos)->delete();

        return response()->json([
            'message' => 'Order placed successfully',
            'orderIds' => $order->order_no,
            'grandTotal' => $grandTotal,
            'cartTrxnIds' => $request->payctrxn_nos,
            'productList' => $items
        ]);
    }

    public function orderNow(Request $request){

        $request->validate([
            'productList' => 'required|array|min:1',
            'productList.*.productIds' => 'required|exists:products,product_no',
            'productList.*.quantiry' => 'required|integer|min:1',
        ]);

        $customer = $request->user();

        $productNos = collect($request->productList)->pluck('productIds');
        $productMap = Product::whereIn('product_no', $productNos)->get()->keyBy('product_no');

        $items = collect();
        $grandTotal = 0;

        foreach ($request->productList as $entry) {
            $product_no = $entry['productIds'];
            $quantity = $entry['quantiry'];

            if (!$productMap->has($product_no)) {
                return response()->json(['message' => "Product ID $product_no not found"], 404);
            }

            $product = $productMap[$product_no];
            $subtotal = $product->product_unit_price * $quantity;

            $items->push([
                'product_no' => $product_no,
                'seller_no' => $product->seller_no,
                'quantity' => $quantity,
                'unit_price' => $product->product_unit_price,
                'subtotal' => $subtotal,
            ]);

            $grandTotal += $subtotal;
        }

        if ($customer->customer_balance < $grandTotal) {
            return response()->json(['message' => 'Insufficient balance'], 400);
        }

        // Create order
        $order = Order::create([
            'order_status' => 'D',
            'order_grand_total' => $grandTotal,
            'payment_date' => now(),
            'customer_no' => $customer->customer_no,
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_no' => $order->order_no,
                'product_no' => $item['product_no'],
                'seller_no' => $item['seller_no'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        // Deduct customer balance
        $customer->customer_balance -= $grandTotal;
        $customer->save();

        return response()->json([
            'message' => 'Order placed successfully',
            'orderNumber' => $order->order_no,
            'grandTotal' => $grandTotal,
            'itemList' => $items
        ]);
    }

    public function cancelOrder(Request $request){

         $request->validate([
            'reason' => 'required',
            'orderNo' => 'exists:orders,order_no',
        ]);

        $customer = $request->user();

        $order = Order::where('order_no', $request->orderNo)
            ->where('customer_no', $customer->customer_no)
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $cancelDeadline = $order->created_at->addMinutes(10);

        if (now()->lessThanOrEqualTo($cancelDeadline)) {
            //Can auto cancel
            $order->order_status = 'C'; // C = Cancelled
            $order->cancel_req_date = now(); 
            $order->cancel_approval_date = now(); 
            $order->cancel_by = 0; 
            $order->save();

            $customer->customer_balance += $order->order_grand_total;
            $customer->save();

            return response()->json([
                'message' => 'Order cancelled successfully.',
                'orderNo' => $order->order_no,
                'currentStatus' =>  $order->order_status 
            ]);
        } else {
            //Request seller approval
            $order->order_status = 'P'; // P = Pending Cancellation Approval
            $order->cancel_req_date = now(); 
            $order->save();

            return response()->json([
                'message' => 'Cancellation requested. Awaiting seller approval.',
                'order_no' => $order->order_no,
                'currentStatus' =>  $order->order_status 
            ]);
        }
    }

     
    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

}
