<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{Auth, Hash};

class AuthController extends Controller
{
    public function loginGet()
    {
        $title = "Đăng Nhập";
        return view('/auth/login', compact("title"));
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $message = "Đăng nhập thành công";

            myFlasherBuilder(message: $message, success: true);
            return redirect('/home');
        }
        $message = "Sai thông tin đăng nhập";
        myFlasherBuilder(message: $message, failed: true);
        return back();
    }

    public function registrationGet()
    {
        $title = "Đăng Ký";
        return view('/auth/register', compact("title"));
    }

    public function registrationPost(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|max:255',
            'username' => 'required|max:15',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|confirmed|min:4',
            'phone' => 'required|numeric',
            'gender' => 'required',
            'address' => 'required',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['image'] = env("IMAGE_PROFILE");
        $validatedData = array_merge($validatedData, [
            "coupon" => 0,
            "point" => 0,
            'remember_token' => Str::random(30),
            'role_id' => 2
        ]);

        try {
            User::create($validatedData);
            $message = "Tạo tài khoản thành công";
            myFlasherBuilder(message: $message, success: true);
            return redirect('/auth/login');
        } catch (\Illuminate\Database\QueryException $exception) {
            return abort(500);
        }
    }


    public function logoutPost()
    {
        try {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            $message = "Đăng xuất thành công";
            myFlasherBuilder(message: $message, success: true);
            return redirect('/auth');
        } catch (\Illuminate\Database\QueryException $exception) {
            return abort(500);
        }
    }
}
