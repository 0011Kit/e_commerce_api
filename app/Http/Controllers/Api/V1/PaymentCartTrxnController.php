<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\PaymentCartTrxn;
use App\Http\Requests\StorePaymentCartTrxnRequest;
use App\Http\Requests\UpdatePaymentCartTrxnRequest;
use App\Models\PaymentCartDtl;

class PaymentCartTrxnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PaymentCartDtl::alll();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentCartTrxnRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentCartTrxn $paymentCartTrxn)
    {
        return $paymentCartTrxn;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentCartTrxn $paymentCartTrxn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentCartTrxnRequest $request, PaymentCartTrxn $paymentCartTrxn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentCartTrxn $paymentCartTrxn)
    {
        //
    }
}
