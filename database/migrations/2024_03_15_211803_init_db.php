<?php

use Illuminate\Database\Migrations\Migration;
use Tpetry\PostgresqlEnhanced\Schema\Blueprint;
use Tpetry\PostgresqlEnhanced\Schema\Concerns\ZeroDowntimeMigration;
use Tpetry\PostgresqlEnhanced\Support\Facades\Schema;

return new class extends Migration {
    use ZeroDowntimeMigration;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->identity(always: true)->primary();
            $table->string('name');
            $table->timestampsTz();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar_url')->nullable();

            $table->foreignId('company_id')
                ->nullable()
                ->references('id')
                ->on('companies');
        });

        Schema::create('company_jobs', function (Blueprint $table) {
            $table->identity(always: true)->primary();

            $table->string('name');
            $table->integer('duration');
            $table->timestampsTz();
            $table->foreignId('company_id')
                ->references('id')
                ->on('companies');
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->identity(always: true)->primary();
            $table->dateTimeTz('schedule_date')->nullable();
            $table->timestampsTz();
            $table->timestampMultiRange('dates');

            $table->foreignId('company_id')
                ->references('id')
                ->on('companies');
            $table->foreignId('manager_id')
                ->nullable()
                ->references('id')
                ->on('users');
            $table->foreignId('company_job_id')->references('id')->on('company_jobs');
            $table->foreignId('user_id')->references('id')->on('users');
        });
    }
};
