<?php

namespace Database\Seeders;

use App\Utils\Permissions;
use App\Utils\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    protected array $userPermissions = [
        Permissions::ViewAllUsers,
        Permissions::ViewUsers,
        Permissions::CreateUser,
        Permissions::EditUser,
        Permissions::DeleteUser,
    ];

    protected array $jobPermissions = [
        Permissions::ViewAllJobs,
        Permissions::ViewJobs,
        Permissions::CreateJob,
        Permissions::EditJob,
        Permissions::DeleteJob,
    ];

    protected array $companyPermissions = [
        Permissions::ViewAllCompanies,
        Permissions::CreateCompany,
        Permissions::EditCompany,
        Permissions::DeleteCompany,
    ];

    protected array $schedulePermissions = [
        Permissions::ViewAllSchedules,
        Permissions::ViewScheduleCalendar,
        Permissions::CreateSchedule,
        Permissions::DeleteSchedule,
        Permissions::EditSchedule,
    ];

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            ...$this->userPermissions,
            ...$this->jobPermissions,
            ...$this->companyPermissions,
            ...$this->schedulePermissions,
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $roles = [
            Roles::Admin => [
                ...collect($this->userPermissions)
                    ->filter(fn(string $permission) => !in_array($permission, [
                        Permissions::ViewUsers,
                    ]))
                    ->toArray(),
                ...collect($this->jobPermissions)
                    ->filter(fn(string $permission) => !in_array($permission, [
                        Permissions::ViewJobs,
                    ]))
                    ->toArray(),
                ...collect($this->companyPermissions)
                    ->toArray()
            ],
            Roles::CompanyManager => [
                ...collect($this->userPermissions)
                    ->filter(fn(string $permission) => !in_array($permission, [
                        Permissions::ViewAllUsers,
                    ]))
                    ->toArray(),
                ...collect($this->jobPermissions)
                    ->filter(fn(string $permission) => !in_array($permission, [
                        Permissions::ViewAllJobs,
                    ]))
                    ->toArray(),
                ...collect($this->schedulePermissions)
                    ->toArray(),
            ],
            Roles::CompanyUser => [
                Permissions::ViewScheduleCalendar
            ]
        ];

        foreach ($roles as $role => $permissions) {
            $sales = Role::create(['name' => $role]);
            $sales->givePermissionTo($permissions);
        }
    }
}
