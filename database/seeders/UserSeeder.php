<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     *
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "fullname" => "Phạm Minh D",
            "username" => "phamminhd",
            "email" => "phamminhd@gmail.com",
            "password" => Hash::make("1234"),
            "image" => env("IMAGE_PROFILE"),
            "phone" => "0934567890",
            "gender" => "Nam",
            "address" => "Số 99, đường Phạm Văn Đồng, Hải Phòng",
            "role_id" => 2,
            'remember_token' => Str::random(30),
        ]);
            User::create([
            "fullname" => "Nguyễn Văn Chiến",
            "username" => "chien2005",
            "email" => "chien2005@gmail.com",
            "password" => Hash::make("1"),
            "image" => env("IMAGE_PROFILE"),
            "phone" => "0328062539",
            "gender" => "Nam",
            "address" => "Mê Linh, Hà Nội",
            "role_id" => 1,
            'remember_token' => Str::random(30),
        ]);

    }
}
