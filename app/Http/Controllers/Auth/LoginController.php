<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Log the user out and redirect to the login page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // Redirect to Google for authentication
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle callback from Google
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Google authentication failed');
        }

        $email = $googleUser->getEmail();
        if (! $email) {
            return redirect('/login')->withErrors('Email not provided by Google');
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            // create a new user; password null per spec
            $user = User::create([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                'email' => $email,
                'password' => null,
            ]);
            $user->id_google = $googleUser->getId();
            $user->save();
        } else {
            // update id_google if missing
            if (empty($user->id_google)) {
                $user->id_google = $googleUser->getId();
                $user->save();
            }
        }

        // Generate OTP (6 digits), save to user, send via email
        $otp = random_int(100000, 999999);
        $user->otp = (string) $otp;
        $user->save();

        Mail::raw("Kode OTP Anda: {$otp}", function ($message) use ($user) {
            $message->to($user->email)->subject('OTP Login');
        });

        return redirect()->route('otp.view', ['id' => $user->id]);
    }
}
