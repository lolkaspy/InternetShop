<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    protected static ?string $password;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(15)->create();
        //Отдельная запись для админа вне фабрики
        $adminRecord = [
            'name' => "admin",
            'email' => "admin@a",
            'password' => static::$password ??= Hash::make('admin'),
            'remember_token' => Str::random(10),
            'balance' => null,
            'role_id' => 1];
        $user = new User($adminRecord);
        $user->save();

    }
}
