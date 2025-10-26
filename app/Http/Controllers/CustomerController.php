<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * AJAX search for customers.
     * GET /customers/search?q=...
     * Returns JSON array of customers.
     */
    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));

        $query = Customer::query();

        if ($q !== '') {
            $like = "%{$q}%";
            $query->where(function ($qBuilder) use ($like) {
                $qBuilder->where('name', 'like', $like)
                    ->orWhere('phone', 'like', $like)
                    ->orWhere('email', 'like', $like);
            });
        }

        $customers = $query->orderBy('name')
            ->limit(30)
            ->get(['id', 'name', 'email', 'phone']);

        return response()->json($customers);
    }

    /**
     * AJAX store new customer.
     * POST /customers/store/ajax
     * Expects JSON body: name, email, phone, address
     */
    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255|unique:customers,email',
            'phone'   => 'nullable|string|max:50',
            'address' => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        // attach createdby_id if possible (your schema uses employee ids)
        $createdBy = null;
        try {
            if (Auth::check()) {
                // if your user model has employee_id use that; adjust if needed
                $createdBy = auth()->guard('employee')->user()?->employee_id ?? null;
            }
        } catch (\Throwable $t) {
            $createdBy = null;
        }

        $customer = Customer::create(array_merge($data, [
            'createdby_id' => $createdBy,
        ]));

        return response()->json([
            'success' => true,
            'customer' => $customer,
        ]);
    }
}
