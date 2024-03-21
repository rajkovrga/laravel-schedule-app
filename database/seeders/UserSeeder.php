<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use App\Utils\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::create([
            'name' => 'rajkovrga',
            'email' => 'rajko@vrga.dev',
            'password' => '12345',
            'email_verified_at' => now(),
        ]);

        $adminUser->assignRole(Roles::Admin);

        $adminUser = User::create([
            'name' => 'rajkov',
            'email' => 'manager@vrga.dev',
            'password' => '12345',
            'email_verified_at' => now(),
            'company_id' => Company::all()->random()->id
        ]);

        $adminUser->assignRole(Roles::CompanyManager);

        $users = User::factory()
            ->count(100)
            ->state(new Sequence(
                fn(Sequence $sequence) => ['company_id' => Company::all()->random()],
            ))
            ->create();

        $roles = Role::all('name')->whereNotIn('name', [Roles::Admin])->pluck('name')->toArray();

        foreach ($users as $user) {
            $user->assignRole(fake()->randomElement($roles));
        }
    }
}
