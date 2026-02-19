<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    // show OTP input form
    public function index($id)
    {
        $user = User::findOrFail($id);
        return view('auth.otp', compact('user'));
    }

    // verify OTP and login
    public function verify(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'otp' => 'required|digits:6',
        ]);

        $user = User::find($request->input('id'));
        if (! $user) {
            return back()->withErrors('User tidak ditemukan');
        }

        if ($user->otp && (string)$user->otp === (string)$request->input('otp')) {
            $user->otp = null;
            $user->save();

            Auth::login($user);
            return redirect('/home');
        }

        return back()->withErrors('OTP tidak valid');
    }
}
