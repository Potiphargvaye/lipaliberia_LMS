<?php

namespace App\Http\Controllers\Admin\AccessControl;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display all roles.
     */
    public function index(Request $request)
    {
        $roles = Role::withCount('users')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.access-control.roles.index', compact('roles'));
    }
    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.access-control.roles.create');
    }

    /**
     * Store a new role.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
        ]);

        Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()
            ->route('admin.access-control.roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Show edit form.
     */
    public function edit(Role $role)
    {
        return view('admin.access-control.roles.edit', compact('role'));
    }

    /**
     * Update role.
     */
    public function update(Request $request, Role $role)
    {
        if ($role->name === 'Super Admin') {
            return back()->with('error', 'Super Admin role cannot be renamed.');
        }

        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name,' . $role->id,
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.access-control.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Delete role. 
     */
    public function destroy(Role $role)
    {
        if ($role->name === 'Super Admin') {
            return back()->with('error', 'Super Admin role cannot be deleted.');
        }

        if ($role->users()->count() > 0) {
            return back()->with(
                'error',
                'Cannot delete a role that is assigned to users.'
            );
        }

        $role->delete();

        return redirect()
            ->route('admin.access-control.roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
