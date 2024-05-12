<?php

namespace App\Http\Controllers;

use App\Enums\Permissions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware(
                PermissionMiddleware::using([
                    Permissions::ShowRoles->getValue()
                ]), only: ['index', 'show']
            ),
            new Middleware(
                PermissionMiddleware::using([
                    Permissions::CreateRoles->getValue()
                ]), only: ['create', 'store']
            ),
            new Middleware(
                PermissionMiddleware::using([
                    Permissions::EditRoles->getValue()
                ]), only: ['edit', 'update']
            ),
            new Middleware(
                PermissionMiddleware::using([
                    Permissions::DeleteRoles->getValue()
                ]), only: ['destroy']
            ),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.roles.index', [
            'roles' => Role::orderBy('id')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create', [
            'permissions' => Permission::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required','max:255'],
            'title' => ['required','max:255'],
            'perms' => ['required', 'exists:permissions,id']
        ]);

        $role = Role::create([
            'name' => $request->name,
            'title' => $request->title,
        ]);

        $role->syncPermissions(
            array_column(Permission::find($request->perms)->all(), 'name')
        );

        return redirect()
            ->route('roles.index')
            ->with('success', 'Данные роли успешно сохранены');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $role)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($role)
    {
        $role = Role::find($role);
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'perms' => 'exists:permissions,id',
        ]);

        $role = Role::find($id);

        if (auth()->user()->can(Permissions::AssignPermissions->value)) {
            $permissions = [];
            if ($request->perms) {
                $permissions = array_column(
                    Permission::find($request->perms)->all(), 'name'
                );
            }
            $role->syncPermissions($permissions);
        }
        return redirect()
            ->route('roles.index')
            ->with('success', 'Данные роли успешно обновлены');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        Role::find($id)->delete();

        return redirect()
            ->route('roles.index')
            ->with('success', 'Роль успешно удалена');
    }
}
