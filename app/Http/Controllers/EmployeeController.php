<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            Gate::authorize('manage-employees');
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = User::where('role', 'employee');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $perPage = in_array($request->per_page, [5, 10, 15]) ? (int) $request->per_page : 5;

        $sortField = match ($request->sort) {
            'oldest' => 'created_at',
            'updated' => 'updated_at',
            'oldest_updated' => 'updated_at',
            'name_asc' => 'name',
            'name_desc' => 'name',
            default => 'created_at',
        };

        $sortDir = match ($request->sort) {
            'oldest', 'oldest_updated', 'name_asc' => 'asc',
            default => 'desc',
        };

        $employees = $query->orderBy($sortField, $sortDir)->paginate($perPage)->withQueryString();

        session(['employees.index_url' => $request->fullUrl()]);

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'employee',
            'is_active' => true,
        ]);

        return redirect(session('employees.index_url', route('employees.index')))
            ->with('toast', __('messages.employee_created'));
    }

    public function edit(User $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, User $employee)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($employee->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'is_active' => ['boolean'],
        ]);

        $employee->name = $validated['name'];
        $employee->email = $validated['email'];

        if ($request->filled('password')) {
            $employee->password = Hash::make($validated['password']);
        }

        $employee->is_active = $request->boolean('is_active');
        $employee->save();

        return redirect(session('employees.index_url', route('employees.index')))
            ->with('toast', __('messages.employee_updated'));
    }

    public function destroy(User $employee)
    {
        if (!session('password_verified', false)) {
            request()->validate([
                'current_password' => ['required', 'current_password'],
            ]);
            session(['password_verified' => true]);
        }

        $employee->delete();

        return redirect(session('employees.index_url', route('employees.index')))
            ->with('toast', __('messages.employee_deleted'));
    }

    public function bulkDestroy(Request $request)
    {
        if (!session('password_verified', false)) {
            $request->validate(['current_password' => ['required', 'current_password']]);
            session(['password_verified' => true]);
        }

        $ids = $request->validate(['ids' => ['required', 'array', 'min:1']])['ids'];

        $adminsInSelection = User::whereIn('id', $ids)->where('role', 'admin')->count();
        if ($adminsInSelection > 0) {
            return back()->withErrors(['ids' => __('messages.cannot_delete_admin')]);
        }

        User::whereIn('id', $ids)->where('role', 'employee')->delete();

        $count = count($ids);
        return redirect(session('employees.index_url', route('employees.index')))
            ->with('toast', __('messages.employees_deleted', ['count' => $count]));
    }
}
