<?php
    namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

    class AuthController extends Controller
    {
        public function index()
        {
            return view('layouts.auth');
        }

        public function auth(Request $request) : RedirectResponse{
            DB::beginTransaction();
            try {
                $request->validate([
                    'email' => 'required|email',
                    'password' => 'required'
                ]);
                $user = User::where('email', $request->email)->first();
                if ($user && $request->password === $user->password) {
                    Auth::login($user);
                   return redirect()->route('admin.show');
                } else {
                    return redirect()->route('auth.show')->with('error', 'Неправильный email или пароль');
                }
            }
            catch (\Exception $e) {
                DB::rollback();
                return redirect()->route('auth.show')->with('error', $e->getMessage());
            }
        }
    }
