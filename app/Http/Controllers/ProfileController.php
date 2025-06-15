<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Hash, Storage};
use Illuminate\Contracts\Support\ValidatedData;

class ProfileController extends Controller
{
    public function myProfile()
    {
        $title = "Hồ sơ của tôi";
        return view('/profile/my_profile', compact("title"));
    }

    public function editProfileGet()
    {
        $title = "Chỉnh sửa hồ sơ";
        return view("/profile/edit_profile", compact("title"));
    }

    public function editProfilePost(Request $request, User $user)
    {
        $rules = [
            'fullname' => 'required|max:255',
            'phone' => 'required|numeric',
            'address' => 'required',
        ];

        if (auth()->user()->username != $request->username) {
            $rules['username'] = 'required|max:15|unique:users,username';
        } else {
            $rules['username'] = 'required|max:15';
        }
        if ($request->file("image")) {
            $rules["image"] = "image|file|max:2048";
        }

        $validatedData = $request->validate($rules);

        try {
            if ($request->file("image")) {
                if ($request->oldImage != env("IMAGE_PROFILE")) {
                    Storage::delete($request->oldImage);
                }
                $originalFilename = $request->file('image')->getClientOriginalName();
                $path = 'profile/' . $originalFilename;
                if (Storage::exists($path)) {
                    $filenameWithoutExt = pathinfo($originalFilename, PATHINFO_FILENAME);
                    $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);
                    $uniqueFilename = $filenameWithoutExt . '_' . time() . '.' . $extension;
                    $path = 'profile/' . $uniqueFilename;
                }
                $request->file('image')->storeAs('profile', basename($path));
                $validatedData["image"] = $path;
            }

            $user->fill($validatedData);
            if ($user->isDirty()) {
                $user->save();
                $message = "Hồ sơ của bạn đã được cập nhật!";
                myFlasherBuilder(message: $message, success: true);
                return redirect("/profile/edit_profile");
            } else {
                $message = "Hành động <strong>thất bại</strong>, không có thay đổi nào được phát hiện!";
                myFlasherBuilder(message: $message, failed: true);
                return redirect("/profile/edit_profile");
            }
        } catch (Exception $exception) {
            return abort(500);
        }
    }

    public function changePasswordGet()
    {
        $title = "Đổi mật khẩu";
        return view("/profile/change_password", compact("title"));
    }

    public function changePasswordPost(Request $request)
    {
        $validated = $request->validate([
            "current_password" => "required|min:4",
            "password" => "required|confirmed|min:4",
            "password_confirmation" => "required|min:4",
        ]);

        if (!(Hash::check($request->current_password, auth()->user()->password))) {
            $message = "Mật khẩu hiện tại không đúng!";
            myFlasherBuilder(message: $message, failed: true);
            return back();
        } else if ($request->current_password == $request->password) {
            $message = "Mật khẩu mới không được trùng với mật khẩu hiện tại!";
            myFlasherBuilder(message: $message, failed: true);
            return back();
        }

        User::where('id', auth()->user()->id)
            ->update(['password' => Hash::make($validated['password'])]);
        $message = "Mật khẩu đã được cập nhật";
        myFlasherBuilder(message: $message, success: true);
        return redirect("/home");
    }
}
