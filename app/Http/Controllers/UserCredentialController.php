<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserCredentialController extends Controller
{
    /**
     * Show form to reset email & password for a user
     */
    public function edit(User $user)
    {
        $title = 'Reset User Credentials';

        return view('backend.pages.user.credentials', compact('user', 'title'));
    }

    /**
     * Update email & password
     */
    public function update(Request $request, User $user)
    {
        // validate
        $request->validate([
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'password'    => 'nullable|min:6|confirmed',
            'send_email'  => 'nullable|boolean',
        ]);

        // keep old email for info
        $oldEmail = $user->email;

        // update email
        $user->email = $request->email;

        $plainPassword = null;

        // if password field filled, reset password
        if ($request->filled('password')) {
            $plainPassword   = $request->password;
            $user->password  = Hash::make($plainPassword);
        }

        $user->save();

        // Optionally send email with new credentials
        if ($request->boolean('send_email') && $plainPassword) {
            try {
                Mail::raw(
                    "Hello {$user->name},\n\nYour login credentials have been updated.\n\n".
                    "Login email: {$user->email}\nNew password: {$plainPassword}\n\n".
                    "Please change your password after login.\n",
                    function ($message) use ($user) {
                        $message->to($user->email)
                                ->subject('Your login credentials have been reset');
                    }
                );
            } catch (\Exception $e) {
                // you can log the error if needed
            }
        }

        return redirect()
            ->route('user.index')
            ->with('success', 'User email/password updated successfully.');
    }
}
