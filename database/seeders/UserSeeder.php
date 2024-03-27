<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyJob;
use App\Models\User;
use App\Utils\Roles;
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
        $company = Company::create([
            'name' => 'Vrga DEV'
        ]);

        $adminUser = User::create([
            'name' => 'rajkovrga',
            'email' => 'rajko@vrga.dev',
            'password' => '12345',
            'email_verified_at' => now(),
            'company_id' => $company->id,
        ]);

        $adminUser->assignRole(Roles::Admin);

        $adminUser = User::create([
            'name' => 'rajkovrga',
            'email' => 'manager@vrga.dev',
            'password' => '12345',
            'email_verified_at' => now(),
            'company_id' => $company->id,
        ]);

        $adminUser->assignRole(Roles::CompanyManager);

        $adminUser = User::create([
            'name' => 'rajkovrga',
            'email' => 'user@vrga.dev',
            'password' => '12345',
            'email_verified_at' => now(),
            'company_id' => $company->id,
        ]);

        $adminUser->assignRole(Roles::User);

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

        $jobs = [
            [
                'name' => 'Vrga DEV',
                'company_id' => $company->id,
                'duration' => 10
            ],
            [
                'name' => 'Vrga DEV 2',
                'company_id' => $company->id,
                'duration' => 30
            ],
            [
                'name' => 'Vrga DEV 3',
                'company_id' => $company->id,
                'duration' => 70
            ]];

        foreach ($jobs as $item) {
            CompanyJob::create($item);
        }
    }
}
