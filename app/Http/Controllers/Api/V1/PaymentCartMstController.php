<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\PaymentCartMst;
use App\Http\Requests\StorePaymentCartMstRequest;
use App\Http\Requests\UpdatePaymentCartMstRequest;
use App\Http\Resources\V1\PaymentCartCollection;

class PaymentCartMstController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PaymentCartCollection(PaymentCartMst::paginate());
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
    public function store(StorePaymentCartMstRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentCartMst $paymentCartMst)
    {
        return $paymentCartMst;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentCartMst $paymentCartMst)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentCartMstRequest $request, PaymentCartMst $paymentCartMst)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentCartMst $paymentCartMst)
    {
        //
    }
}
