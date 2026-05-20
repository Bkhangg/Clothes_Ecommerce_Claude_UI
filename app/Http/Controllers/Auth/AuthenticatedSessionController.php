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
        try {
            $request->authenticate();
        } catch (ValidationException $e) {
            $error = collect($e->errors())->flatten()->first() ?? __('auth.failed');
            return back()->with('toast_error', $error);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false))
            ->with('toast', __('messages.welcome_back_toast', ['name' => Auth::user()->name]));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('toast', __('messages.logged_out'));
    }
}