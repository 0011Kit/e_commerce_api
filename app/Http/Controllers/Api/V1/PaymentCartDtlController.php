<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\PaymentCartDtl;
use App\Http\Requests\StorePaymentCartDtlRequest;
use App\Http\Requests\UpdatePaymentCartDtlRequest;

class PaymentCartDtlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PaymentCartDtl::all();
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
    public function store(StorePaymentCartDtlRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentCartDtl $paymentCartDtl)
    {
        return $paymentCartDtl;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentCartDtl $paymentCartDtl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentCartDtlRequest $request, PaymentCartDtl $paymentCartDtl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentCartDtl $paymentCartDtl)
    {
        //
    }
}
