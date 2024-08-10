<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                "email" => "johndoe@mail.com",
                "password" => "johndoe1234"
            ]
        ];

        foreach ($users as $user) {
            User::firstOrCreate([
                "email" => $user["email"],
                "password" => bcrypt($user["password"])
            ]);
        }
    }
}
