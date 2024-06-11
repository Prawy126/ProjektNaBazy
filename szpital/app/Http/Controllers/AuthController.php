<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('logowanie');
    }

    public function login(Request $request)
    {
        if (Gate::allows('is-logged-in')) {
            return back();
        }

        $credentials = $request->only('login', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $accountType = $user->account_type;

            switch ($accountType) {
                case 'admin':
                    return redirect()->intended(route('admin'));
                case 'doctor':
                    return redirect()->intended(route('doctor.dashboard'));
                case 'nurse':
                    return redirect()->intended(route('nurse.dashboard'));
                case 'patient':
                    return redirect()->intended(route('patient.dashboard'));
                default:
                    Auth::logout();
                    return back()->withErrors([
                        'login' => 'Nieznany typ konta!',
                    ]);
            }
        }

        return back()->withErrors([
            'login' => 'Podane dane są nieprawidłowe!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
