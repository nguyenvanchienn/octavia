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
            "fullname" => "Nguyễn Văn Chiến",
            "username" => "NguyenChien",
            "email" => "chien@gmail.com",
            "password" => Hash::make("1"),
            "image" => env("IMAGE_PROFILE"),
            "phone" => "0912345678",
            "gender" => "Nam",
            "address" => "Tiến Thịnh Mê Linh Hà Nội",
            "role_id" => 1,
            'remember_token' => Str::random(30),
        ]);
            User::create([
            "fullname" => "Hoàng Tuấn Kiệt",
            "username" => "TuanKiet",
            "email" => "tuankiet@gmail.com",
            "password" => Hash::make("1"),
            "image" => env("IMAGE_PROFILE"),
            "phone" => "0974807212",
            "gender" => "Nam",
            "address" => "Ngõ 197 Văn Quán Hà Đông",
            "role_id" => 2,
            'remember_token' => Str::random(30),
        ]);
    }
}
