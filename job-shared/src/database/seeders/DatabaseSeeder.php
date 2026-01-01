<?php

namespace Database\Seeders;

use App\Models\company;
use App\Models\job_application;
use App\Models\job_category;
use App\Models\job_vacancy;
use App\Models\resume;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use function Symfony\Component\Clock\now;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        

            User::firstOrCreate(
            ['email' => 'Admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('123456789'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $jobData = json_decode(file_get_contents(base_path('database/data/job_data.json')), true);
        $jobApplications = json_decode(file_get_contents(base_path('database/data/job_applications.json')), true);

        // إنشاء job categories
        foreach ($jobData['job_categories'] as $category) {
            job_category::firstOrCreate(['name' => $category]); // job_category
        }

        // إنشاء companies و company owners
        foreach ($jobData['companies'] as $company) {
            $companyOwner = User::firstOrCreate(
                ['email' => fake()->unique()->safeEmail()],
                [
                    'name' => fake()->name(),
                    'password' => Hash::make('12345678'),
                    'role' => 'company-owner',
                    'email_verified_at' => now(),
                ]
            );

            company::firstOrCreate( // company
                ['name' => $company['name']],
                [
                    'address' => $company['address'],
                    'industry' => $company['industry'],
                    'website' => $company['website'],
                    'description' => $company['description'],
                    'ownerID' => $companyOwner->id,
                ]
            );
        }

        // إنشاء job vacancies
        foreach ($jobData['jobVacancies'] as $job) {
            $company = company::where('name', $job['company'])->firstOrFail(); // company
            $jobCategory = job_category::where('name', $job['category'])->firstOrFail(); // job_category

            $jobVacancy = job_vacancy::firstOrCreate( // job_vacancy
                ['title' => $job['title'], 'companyID' => $company->id],
                [
                    'description' => $job['description'],
                    'location' => $job['location'],
                    'salary' => $job['salary'],
                    'type' => $job['type'],
                    'categoryID' => $jobCategory->id,
                ]
            );

            // إنشاء job applications
            foreach ($jobApplications['job_applications'] as $application) {
                $applicant = User::firstOrCreate(
                    ['email' => fake()->unique()->safeEmail()],
                    [
                        'name' => fake()->name(),
                        'password' => Hash::make('12345678'),
                        'role' => 'job-seeker',
                        'email_verified_at' => now(),
                    ]
                );

                $resume = resume::create([ // resume
                    'userID' => $applicant->id,
                    'filename' => $application["resume"]['filename'],
                    'fileUri' => $application["resume"]['fileUri'],
                    'contactDetails' => $application["resume"]['contactDetails'],
                    'summary' => $application["resume"]['summary'],
                    'skills' => $application["resume"]['skills'],
                    'experience' => $application["resume"]['experience'],
                    'education' => $application["resume"]['education']
                ]);

                job_application::create([ // job_application
                    'jobVacancyID' => $jobVacancy->id,
                    'userID' => $applicant->id,
                    'resumeID' => $resume->id,
                    'status' => $application['status'],
                    'aiGeneratedScore' => $application['aiGeneratedScore'] ?? 0,
                    'aiGeneratedFeedback' => $application['aiGeneratedFeedback'] ?? null,
                ]);
            }
        }
    }
}