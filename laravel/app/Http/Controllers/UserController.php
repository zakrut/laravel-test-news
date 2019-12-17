<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email'     => 'required|string|email|max:255',
            'password'  => 'required|string|min:4',
        ]); 
        $message = 'error';
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password], $request->remember))
        {
            $message = 'success_auth';
        }
        return redirect()->intended(route('main'))->with('message', $message);
    }

    public function register(Request $request){
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:4|confirmed',
        ]);        
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);
        auth()->login($user);
        return redirect()->intended(route('main'))->with('message', 'success_auth');
    }

    public function exit(){
        auth()->logout();
        session()->flush();
        return redirect()->intended(route('main'))->with('message', 'exit_auth');
    }
}
