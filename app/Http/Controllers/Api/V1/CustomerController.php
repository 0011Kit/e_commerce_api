<?php

namespace App\Http\Controllers\Api\V1; 

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\v1\CustomerResource;
use App\Http\Resources\V1\CustomerCollection;
use App\Filters\V1\CustomerFilter;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterPage = new CustomerFilter();
        $queryItems = $filterPage->transform($request);
        $sort = $filterPage->getSort($request);

        $customers = count($queryItems)
            ? Customer::where($queryItems)
            : Customer::query();

        if (!empty($sort)) {
            foreach ($sort as [$column, $direction]) {
                $customers->orderBy($column, $direction);
            }
        }else{
            $customers->orderBy('customer_name');
        }

        $result = $customers->paginate();

        return response() -> json([
                'message' => 'Customer List retrieved successfully.',
                'data' => new CustomerCollection($result)            
        ]);
    }

   
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    // public function show(Customer $customer)
    // {
    //     return new CustomerResource($customer);
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
