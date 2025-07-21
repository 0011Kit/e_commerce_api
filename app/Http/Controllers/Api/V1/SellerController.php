<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\SellerFilter;
use App\Models\Seller;
use App\Http\Requests\StoreSellerRequest;
use App\Http\Requests\UpdateSellerRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\SellerResource;
use App\Http\Resources\V1\SellerCollection;
use App\Filters\V1\SellerQuery;
use Illuminate\Http\Request;



class SellerController extends Controller{ 
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterPage = new SellerFilter();
        $queryItems = $filterPage->transform($request);
        $sort = $filterPage->getSort($request);

        $sellers = count($queryItems)
            ? Seller::where($queryItems)
            : Seller::query();

        if (!empty($sort)) {
            foreach ($sort as [$column, $direction]) {
                $sellers->orderBy($column, $direction);
            }
        }else{
            $sellers->orderBy('seller_name');
        }

        $result = $sellers->paginate();

        return response()->json([
            'message' => 'Seller List retrieved successfully.',
            'data' => new SellerCollection($result)
        ]);
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
    public function store(StoreSellerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Seller $seller)
    {
        return new SellerResource($seller);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seller $seller)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSellerRequest $request, Seller $seller)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seller $seller)
    {
        //
    }
}
