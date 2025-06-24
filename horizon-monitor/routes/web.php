<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

Route::get('/', function () {
    return redirect(config('horizon.path'));
});

Route::fallback(function () {
    return redirect(config('horizon.path'));
});


Route::middleware(['web'])->group(function () {

    Route::get('/auth/error', function () {
        return response()->view('auth-error', [], 403);
    })->name('auth.error');

    Route::get('/auth/redirect', function () {
        return Socialite::driver(env('OAUTH_PROVIDER'))->redirect();
    })->name('redirect');

    Route::get('/auth/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->intended(config('horizon.path'));
    })->name('logout');
 
    Route::get('/auth/callback', function () {

        try {
            $user = Socialite::driver(env('OAUTH_PROVIDER'))->user();

            $user = User::updateOrCreate([
                'email' => $user->email,
            ], [
                'name' => $user->name,
                'access_token' => $user->token,
                'refresh_token' => $user->refreshToken,
                'provider_user_id' => $user->id,
                'expires_in' => $user->expiresIn,
                'password' => time()
            ]);

            Auth::login($user);

            return redirect()->intended(config('horizon.path'));
        } catch(\Exception $e) {
            return Redirect::route('auth.error')->with('error', $e->getMessage());
        }
    });
});