<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index()
    {
        $user = Auth::guard('employee')->user();

        // base query
        $query = Employee::query();

        // if user is not superadmin → hide admin & superadmin
        if ($user->role !== 'superadmin') {
            $query->whereNotIn('role', ['admin', 'superadmin']);
        }

        // counts (respecting role visibility)
        $totalEmployees    = (clone $query)->count();
        $activeEmployees   = (clone $query)->where('active_status', true)->count();
        $inactiveEmployees = (clone $query)->where('active_status', false)->count();
        $rolesCount        = (clone $query)->select('role')->distinct()->count();

        // list (respecting role visibility)
        $employees = $query->with(['createdBy'])->paginate(10);

        return view('pages.employee.staff-management', compact(
            'totalEmployees',
            'activeEmployees',
            'inactiveEmployees',
            'rolesCount',
            'employees'
        ));
    }

    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'first_name'    => 'required|string|max:50',
            'last_name'     => 'required|string|max:50',
            'role'          => 'required|in:staff,manager,admin,superadmin,cashier,technician',
            'email_address' => 'required|email|unique:employees,email_address',
            'username'      => 'required|string|unique:employees,username',
            'password'      => 'required|string|min:8|confirmed',
            'phone_number'  => 'nullable|string|max:20',
            'branch_id'     => 'required|exists:branches,branch_id',
            'avatar'        => 'nullable|image|max:2048',
        ]);

        // Handle avatar upload if exists
        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Hash password
        $validated['password'] = bcrypt($validated['password']);

        // Set created_by ID as numeric employee_id
        $validated['createdby_id'] = auth()->guard('employee')->user()?->employee_id;
        $validated['created_date'] = now();

        // Create employee
        $employee = Employee::create($validated);

        // Return JSON response for AJAX
        return response()->json([
            'message' => 'Employee added successfully!',
            'submitted_data' => $validated, // for debugging
            'employee_id' => $employee->employee_id,
        ]);
    }

}
