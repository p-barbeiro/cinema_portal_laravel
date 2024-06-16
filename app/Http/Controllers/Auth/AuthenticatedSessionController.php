<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{

    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->blocked) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('alert-msg', 'Your account has been blocked. Please contact support.')
                    ->with('alert-type', 'danger');
            }

            $request->session()->regenerate();

            return redirect()->route('movies.showcase')
                ->with('alert-msg', 'Welcome back <u>' . Auth::user()->name . '</u>!')
                ->with('alert-type', 'success');
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
