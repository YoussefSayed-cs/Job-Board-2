<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string('filename')->nullable();
            $table->float('aiGeneratedScore', 2)->default(0);
            $table->longText('aiGeneratedFeedback')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Correct Foreign Keys
            $table->uuid('jobVacancyID');
            $table->foreign('jobVacancyID')->references('id')->on('job_vacancies')->onDelete('restrict');

            $table->uuid('resumeID');
            $table->foreign('resumeID')->references('id')->on('resumes')->onDelete('restrict');

            $table->uuid('userID');
            $table->foreign('userID')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
