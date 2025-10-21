<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the suppliers.
     */
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        $totalSuppliers = $suppliers->count();
        $activeSuppliers = $suppliers->where('status', 'active')->count();
        $inactiveSuppliers = $suppliers->where('status', 'inactive')->count();

        return view('pages.settings.suppliers', compact(
            'suppliers',
            'totalSuppliers',
            'activeSuppliers',
            'inactiveSuppliers'
        ));
    }

    /**
     * Store a newly created supplier in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name'   => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone_number'   => 'required|string|max:20',
            'address'        => 'required|string|max:500',
            'notes'          => 'nullable|string|max:500',
        ]);

        $supplier = Supplier::create($validated);

        return response()->json([
            'message' => 'Supplier added successfully!',
            'supplier' => $supplier,
        ]);
    }

    /**
     * Show the form for editing the specified supplier.
     */
    public function edit(Supplier $supplier)
    {
        return response()->json($supplier);
    }

    /**
     * Update the specified supplier in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validator = Validator::make($request->all(), [
            'company_name'   => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email'          => 'required|email|max:255|unique:suppliers,email,' . $supplier->id,
            'phone_number'   => 'required|string|max:20',
            'address'        => 'required|string',
            'notes'          => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $supplier->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Supplier updated successfully.',
            'data'    => $supplier
        ]);
    }

    /**
     * Remove the specified supplier from storage.
     */
    // public function destroy(Supplier $supplier)
    // {
    //     $supplier->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Supplier deleted successfully.'
    //     ]);
    // }
}
