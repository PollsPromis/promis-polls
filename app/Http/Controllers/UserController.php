<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Permissions;
use App\Enums\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\NoReturn;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware(
                PermissionMiddleware::using([
                    Permissions::ShowUsers->getValue()
                ]), only: ['index', 'show']
            ),
            new Middleware(
                PermissionMiddleware::using([
                    Permissions::CreateUsers->getValue()
                ]), only: ['create', 'store']
            ),
            new Middleware(
                PermissionMiddleware::using([
                    Permissions::EditUsers->getValue()
                ]), only: ['edit', 'update']
            ),
            new Middleware(
                PermissionMiddleware::using([
                    Permissions::DeleteUsers->getValue()
                ]), only: ['destroy']
            ),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::orderBy('id')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create', [
            'roles' => Role::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required','max:255'],
            'second_name' => ['required','max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        DB::table('users')->insert([
            'first_name'  => $request->string('first_name')->trim(),
            'second_name' => $request->string('second_name')->trim(),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'login' => time()
        ]);
        $user = User::whereEmail($request->email)->first();
        $user->syncRoles([Roles::User->getValue()]);
        return redirect()
            ->route('users.index')
            ->with('success', 'Данные пользователя успешно сохранены');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        return view('admin.users.edit', [
            'user' => User::findOrFail($id),
            'roles' => Role::all(),
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'first_name' => ['required','max:255'],
            'second_name' => ['required','max:255'],
            'email' => ['required', 'email'],
            'roles' => ['required', 'exists:roles,id'],
        ]);

        $user = User::find($id);

        if ($request->change_password) {
            $user->first_name = $request->input('first_name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->password);
        } else {
            $user->first_name = $request->input('first_name');
            $user->email = $request->input('email');
        }
        $user->save();

        if (auth()->user()->can(Permissions::AssignRoles->value)) {
            $user->syncRoles(array_column(Role::find($request->roles)->all(), 'name'));
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'Данные пользователя успешно обновлены');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        User::find($id)->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Пользователь успешно удален');
    }
}
