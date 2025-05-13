<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomer;
use App\Http\Requests\UpdateCustomer;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index() {
        
        $customer = Customer::get();

        if(!$customer || $customer->count() == 0){
            return response()->json([
                'status' => 'error',
                'message' => 'Customer not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => CustomerResource::collection($customer)
        ], 200);

    }

    public function store(StoreCustomer $request)
    {
        try {
            $customer = Customer::create($request->validated());
            return response()->json([
                'message' => 'Customer added successfully.',
                'data' => new CustomerResource($customer),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Customer creation failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $customer = Customer::find($id);

        if ($customer) {
            return response()->json([
                'message' => 'Success.',
                'data' => new CustomerResource($customer),
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Customer not found.'
            ], 404);
        }
    }

    public function update(UpdateCustomer $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found.'
            ], 404);
        }

        try {
            $customer->update($request->validated());

            return response()->json([
                'message' => "Customer updated successfully.",
                'data' => new CustomerResource($customer->refresh()),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => "Customer update failed.",
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    
    public function destroy(Customer $customer) {
        $customer->delete();

        return response()->json([
            'message' => 'Customer deleted successfully.',
        ], 200);
    }
}
