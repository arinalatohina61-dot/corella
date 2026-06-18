<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        // 2. Теперь роли существуют, и мы можем спокойно создавать пользователя
        User::query()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.ru',
            'password' => Hash::make('qwerty12345'),
            'surname' => 'Admin',
            'phone' => '+7(999)999-99-99',
            'role_id' => 1,
        ]);
    }
}
