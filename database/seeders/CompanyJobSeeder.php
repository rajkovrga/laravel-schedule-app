<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyJob;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class CompanyJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanyJob::factory()
            ->count(100)
            ->state(new Sequence(
                fn (Sequence $sequence) => ['company_id' => Company::all()->random()],
            ))
            ->create();
    }
}
