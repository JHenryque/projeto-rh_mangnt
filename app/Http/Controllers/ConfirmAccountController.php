<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ConfirmAccountController extends Controller
{
    public function confirmAccount($token)
    {
        // check if the token is valid
        $user = User::where('confirmation_token', $token)->first();

        if (!$user) {
            abort(404, 'Invalid confirmation token');
        }

        return view('auth.confirm-account', compact('user'));
    }

    public function confirmAccountSubmit(Request $request)
    {
        // form validation
        $request->validate([
            'token' => 'required|string|size:60',
            'password' => 'required|min:8|confirmed|max:20|regex:/^(?=.*[a-z])(?=.*\d).+$/',
            'password_confirmation' => 'required|confirmed',
        ]);
    }
}
