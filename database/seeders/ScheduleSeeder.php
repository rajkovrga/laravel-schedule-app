<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyJob;
use App\Models\Schedule;
use App\Models\User;
use App\Utils\Roles;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Random\RandomException;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws RandomException
     */
    public function run(): void
    {
        $companyManagers = User::query()->whereHas('roles', function ($query) {
            $query->where('name', Roles::CompanyManager);
        })->get();

        $users = User::all();

        foreach ($users as $user) {
            for ($i = 0; $i < random_int(5, 15); $i++) {
                $company = Company::all()->random();
                $job = CompanyJob::query()->withoutGlobalScopes()->where('company_id', $company->id)->get()->random();
                $manager = $companyManagers->where('company_id', $company->id)->first();
                if ($manager !== null) {
                    Schedule::query()->create([
                        'dates' => [["2024-04-05 23:00:00", "2024-04-06 00:14:00"]],
                        'schedule_date' => Carbon::now()->addHours(random_int(10, 510)),
                        'company_id' => $company->id,
                        'company_job_id' => $job->id,
                        'user_id' => $user->id,
                        'manager_id' => $manager->id
                    ]);
                }
            }
        }
    }
}

