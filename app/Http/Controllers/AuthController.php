<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Ramsey\Uuid\Uuid;

class AuthController extends Controller
{
    public function login(){
        return view('Auth.login');
    }

    public function register(){
        return view('Auth.register');
    }
    
    public function registerAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return redirect('/auth/register')->withErrors($validator->errors());
        }

        $check = User::where('email', $request->email)->first();
        if ($check) {
            return redirect('/auth/register')->withErrors(['msg' => 'Email telah terdaftar']);
        }

        $user = User::create([
            'id' => Uuid::uuid4(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 3
        ]);
        
        return redirect('/auth/register')
            ->withSuccess('Akun anda berhasil didaftarkan, silahkan login 
                    menggunakan email dan password anda ');
    }

    public function loginAction(Request $request)
    {   
        $checkEmail = User::where('email', $request->email)->first();
        if (!$checkEmail) {
            return redirect('/auth/login')->withErrors(['msg' => 'Email tidak terdaftar']);
        }

        if (! Auth::attempt($request->only('email', 'password'))) {
            return redirect('/auth/login')->withErrors(['msg' => 'Password tidak sesuai']);    
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }


}
