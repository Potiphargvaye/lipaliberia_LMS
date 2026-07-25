<?php

namespace App\Http\Controllers\Admin\AccessControl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display all permissions.
     */
    public function index(Request $request)
    {
        $permissions = Permission::withCount('roles')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->appends($request->query());

        // Live search: return only the table partial for AJAX requests
        if ($request->ajax()) {
            return view(
                'admin.access-control.permissions._table',
                compact('permissions')
            )->render();
        }

        return view(
            'admin.access-control.permissions.index',
            compact('permissions')
        );
    }


    /**
     * Show create form.
     */
    public function create()
    {
        return view(
            'admin.access-control.permissions.create'
        );
    }


    /**
     * Store a new permission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:permissions,name'
            ],
        ]);


        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);


        return redirect()
            ->route('admin.access-control.permissions.index')
            ->with('success', 'Permission created successfully.');
    }



    /**
     * Show edit form.
     */
    public function edit(Permission $permission)
    {
        return view(
            'admin.access-control.permissions.edit',
            compact('permission')
        );
    }



    /**
     * Update permission.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:permissions,name,' . $permission->id
            ],
        ]);


        $permission->update([
            'name' => $request->name,
        ]);


        return redirect()
            ->route('admin.access-control.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }




    /**
     * Delete permission.
     */
    public function destroy(Permission $permission)
    {

        /*
        |--------------------------------------------------------------------------
        | Prevent deleting permissions assigned to roles
        |--------------------------------------------------------------------------
        */

        if ($permission->roles()->count() > 0) {

            return back()->with(
                'error',
                'Cannot delete a permission assigned to roles.'
            );
        }


        $permission->delete();


        return redirect()
            ->route('admin.access-control.permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }
}
