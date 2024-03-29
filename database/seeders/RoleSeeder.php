<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleArr = [
            [
                'name' => 'Администратор',
            ],
            [
                'name' => 'Пользователь',
            ]];
        foreach ($roleArr as $item) {
            $role = new Role($item);
            $role->save();
        }


    }
}
