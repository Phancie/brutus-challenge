<?php

namespace App\Http\Controllers;

use App\Mail\LoginMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class CustomAuthController extends Controller
{
    use AuthenticatesUsers;

    public function index()
    {

        return view('signup');
    }

    public function signup(){

        $this->validate(request(), [
         'name'=>'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:12|regex:/[a-z]/|regex:/[A-Z]/
                |regex:/[0-9]/|regex:/[@$!%*#?&]/'


        ]);


        $user = new User();
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = Hash::make(request()->password);
        $user->save();
        return 'signed up';
    }

    public function showLoginForm(){

        return view('login');
    }

    public function login()
    {
        $this->validate(request(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($this->hasTooManyLoginAttempts(request())) {
            $this->fireLockoutEvent(request());
            Mail::to(request()->email)->send(new LoginMail());
//            return $this->sendLockoutResponse(request());
            return 'retry after 5 minutes';
        }

        $credentials = request()->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $this->clearLoginAttempts(request());
            return 'logged in';
        }else{
            $this->incrementLoginAttempts(request());
        }

        return redirect()->back()->withInput(request()->except('password'));

    }

    protected function hasTooManyLoginAttempts(Request $request)
    {
        $maxLoginAttempts = 3;

        $lockoutTime = 5; // In minutes

        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $maxLoginAttempts, $lockoutTime
        );

    }
}
