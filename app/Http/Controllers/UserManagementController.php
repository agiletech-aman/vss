<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Region;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserManagementController extends Controller
{
    /**
     * List users
     */
    public function index()
    {
        $this->authorizeSuperAdmin();

        return view('admin.users.index', [
            'users' => User::with('roles', 'region', 'warehouse')->get()
        ]);
    }

    /**
     * Show create user form
     */
    public function create()
    {
        $this->authorizeSuperAdmin();

        return view('admin.users.create', [
            'roles' => Role::all(),
            'permissions' => Permission::all(),
            'regions' => Region::orderBy('name')->get(),
            'warehouses' => Warehouse::with('region')->orderBy('warehouse')->get(),
        ]);
    }

    /**
     * Store new user
     */
    public function store(Request $request)
    {
        $this->authorizeSuperAdmin();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'roles'    => 'required|array',
            'region_id' => 'nullable|exists:regions,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
        ]);

        // ❌ Prevent assigning superadmin role accidentally
        if (in_array('superadmin', $request->roles)) {
            return back()->withErrors([
                'roles' => 'You cannot assign SuperAdmin role.'
            ])->withInput();
        }

        // ✅ Validate role assignments
        $this->validateRoleAssignment($request);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'region_id' => $request->region_id,
            'warehouse_id' => $request->warehouse_id,
        ]);

        $user->syncRoles($request->roles);

        if ($request->permissions) {
            $user->syncPermissions($request->permissions);
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Edit user
     */
    public function edit(User $user)
    {
        $this->authorizeSuperAdmin();

        // ❌ Prevent editing superadmin
        if ($user->hasRole('superadmin')) {
            abort(403, 'SuperAdmin cannot be modified.');
        }

        return view('admin.users.edit', [
            'user' => $user->load('roles', 'permissions', 'region', 'warehouse'),
            'roles' => Role::all(),
            'permissions' => Permission::all(),
            'regions' => Region::orderBy('name')->get(),
            'warehouses' => Warehouse::with('region')->orderBy('warehouse')->get(),
        ]);
    }

    /**
     * Update user roles & permissions
     */
    public function update(Request $request, User $user)
    {
        $this->authorizeSuperAdmin();

        // ❌ Prevent modifying superadmin
        if ($user->hasRole('superadmin')) {
            abort(403, 'SuperAdmin cannot be modified.');
        }

        $request->validate([
            'roles' => 'required|array',
            'region_id' => 'nullable|exists:regions,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
        ]);

        // ❌ Prevent assigning superadmin role
        if (in_array('superadmin', $request->roles)) {
            return back()->withErrors([
                'roles' => 'You cannot assign SuperAdmin role.'
            ])->withInput();
        }

        // ✅ Validate role assignments
        $this->validateRoleAssignment($request);

        $user->update([
            'region_id' => $request->region_id,
            'warehouse_id' => $request->warehouse_id,
        ]);

        $user->syncRoles($request->roles);
        $user->syncPermissions($request->permissions ?? []);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Delete user safely
     */
    public function destroy(User $user)
    {
        $this->authorizeSuperAdmin();

        // ❌ Prevent deleting SuperAdmin
        if ($user->hasRole('superadmin')) {
            return back()->withErrors([
                'error' => 'SuperAdmin cannot be deleted.'
            ]);
        }

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->withErrors([
                'error' => 'You cannot delete yourself.'
            ]);
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Internal check
     */
    private function authorizeSuperAdmin()
    {
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Only SuperAdmin can access this section.');
        }
    }

    /**
     * Validate region/warehouse assignment based on role
     */
    private function validateRoleAssignment(Request $request)
    {
        $roles = $request->roles;

        // Region Officer MUST have a region assigned
        if (in_array('region_officer', $roles)) {
            if (!$request->region_id) {
                return back()->withErrors([
                    'region_id' => 'Region Officer must be assigned to a region.'
                ])->withInput();
            }
        }

        // Warehouse Officer MUST have a warehouse assigned
        if (in_array('warehouse_officer', $roles)) {
            if (!$request->warehouse_id) {
                return back()->withErrors([
                    'warehouse_id' => 'Warehouse Officer must be assigned to a warehouse.'
                ])->withInput();
            }

            // Validate that warehouse belongs to the selected region (if region is also selected)
            if ($request->region_id) {
                $warehouse = Warehouse::find($request->warehouse_id);
                if ($warehouse && $warehouse->region_id != $request->region_id) {
                    return back()->withErrors([
                        'warehouse_id' => 'Selected warehouse does not belong to the selected region.'
                    ])->withInput();
                }
            }
        }

        return true;
    }
}
