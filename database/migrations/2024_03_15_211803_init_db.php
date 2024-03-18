<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->index('id');
            $table->timestampsTz();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('avatar_url')->nullable();
        });

        Schema::create('company_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('during');
            $table->foreignId('company_id')->references('id')->on('companies');
            $table->timestampsTz();
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->references('id')->on('companies');
            $table->foreignId('manager_id')->references('id')->on('users');
            $table->dateTimeTz('schedule_date');
            $table->timestampsTz();
        });

        Schema::create('schedule_requests', function (Blueprint $table) {
            $table->id();
            $table->dateTimeTz('start_date');
            $table->dateTimeTz('date_time');
            $table->foreignId('company_id')->references('id')->on('companies');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('job_id')->references('id')->on('jobs');
            $table->foreignId('schedule_id')->references('id')->on('schedules');
            $table->timestampsTz();
        });

    }
};
