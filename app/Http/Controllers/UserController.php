<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'password-confirm' => 'required|same:password',
        ]);
        $user = User::create($data);
        if ($user) {
            return redirect('login');
        }
    }
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($data)) {
            return redirect()->route('dashboard');
        }
    }
    public function dashboard(){
        if(Auth::check()){
         return view('dashboard');
        }else{
         return redirect()->route('login');
        }
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function showForgotPasswordForm()
    {
        return view('forgot-password');
    }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        /*  with function */

        // $status = Password::sendResetLink($request->only('email'));
        // return $status === Password::RESET_LINK_SENT
        //     ? back()->with(['status' => __($status)])
        //     : back()->withErrors(['email' => __($status)]);
 
 /*  without function */
 $token = Str::random(64);

 // Save the token to the password_resets table
 DB::table('password_reset_tokens')->updateOrInsert(
     ['email' => $request->email],
     [
         'token' => $token,
         'created_at' => Carbon::now(),
     ]
 );

 // Send the reset link via email
 Mail::send('emails.password-reset', ['token' => $token], function ($message) use ($request) {
     $message->to($request->email);
     $message->subject('Reset Password');
 });

 return back()->with('success', 'We have emailed your password reset link!');
}
  
    public function showResetPasswordForm($token)
    {
        return view('reset-password', ['token' => $token]);
    }

    // Reset Password
    public function resetPassword(Request $request)
    {
        /*with function*/
        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required|confirmed|min:6',
        //     'token' => 'required'
        // ]);

        // $status = Password::reset(
        //     $request->only('email', 'password', 'password_confirmation', 'token'),
        //     function ($user, $password) {
        //         $user->forceFill([
        //             'password' => Hash::make($password),
        //         ])->save();
        //     }
        // );

        // return $status === Password::PASSWORD_RESET
        //     ? redirect()->route('login')->with('status', __($status))
        //     : back()->withErrors(['email' => __($status)]);


        /*without function*/

        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
        ]);
    
        // Verify token
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();
    
        if (!$record) {
            return back()->withErrors(['email' => 'Invalid token or email.']);
        }
    
        // Update the user's password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
    
        // Delete the password reset record
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
    
        return redirect()->route('login')->with('success', 'Password has been reset!');
    }

    
}


