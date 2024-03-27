<?php

namespace App\Utils;

readonly abstract class Permissions
{
    // Users
    public const ViewAllUsers = 'view all users';
    public const ViewUsers = 'view users';
    public const CreateUser = 'create users';
    public const CreateEmployeeUser = 'create employee user';
    public const EditUser = 'edit user';
    public const DeleteUser = 'delete user';

    // Jobs
    public const ViewAllJobs = 'view all jobs';
    public const ViewJobs = 'view jobs';
    public const CreateJob = 'create job';
    public const EditJob = 'edit job';
    public const DeleteJob = 'delete job';

    // Schedules
    public const ViewAllSchedules = 'view all schedules';
    public const ViewScheduleCalendar = 'view schedule request';
    public const CreateSchedule = 'create schedule';
    public const EditSchedule = 'edit schedule';
    public const DeleteSchedule = 'delete schedule';
    public const CreatePotentialSchedule = 'create potential schedule';

    // Companies
    public const ViewAllCompanies = 'view all companies';
    public const CreateCompany = 'create company';
    public const EditCompany = 'edit company';
    public const DeleteCompany = 'delete company';

    public static function all(): array
    {
        return [
            self::ViewAllUsers,
            self::ViewUsers,
            self::CreateUser,
            self::EditUser,
            self::DeleteUser,
            self::ViewAllJobs,
            self::ViewJobs,
            self::CreateJob,
            self::EditJob,
            self::DeleteJob,
            self::ViewAllCompanies,
            self::CreateCompany,
            self::EditCompany,
            self::DeleteCompany,
            self::CreateEmployeeUser,
            self::ViewAllSchedules,
            self::ViewScheduleCalendar,
            self::CreateSchedule,
            self::EditSchedule,
            self::DeleteSchedule,
            self::CreatePotentialSchedule,
        ];
    }
}
