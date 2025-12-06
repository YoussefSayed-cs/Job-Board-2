<?php

namespace App\Http\Controllers;

use App\Models\job_application;
use App\Models\job_vacancy;
use App\Models\User;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

  public function index()
  {
    if (auth()->user()->role == 'admin') {
      $analytics = $this->adminDashboard();
    } else {
      $analytics = $this->companyOwnerDashboard();
    }

    return view('Dashboard.index', compact(['analytics']));

  }

  private function adminDashboard()
  {
    //last 30 days active users (job seekers role)   
    $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))->where('role', 'applicant')->count();

    //Total job vacancies (not deleted)
    $totalJob = job_vacancy::whereNull('deleted_at')->count();


    // Total applications (not deleted)
    $totalapplications = job_application::whereNull('deleted_at')->count();

    $analytics = [
      'activeUsers' => $activeUsers,
      'totalJob' => $totalJob,
      'totalapplications' => $totalapplications,
    ];

    // Most applied jobs
    $mostAppliedJobs = job_vacancy::withCount('job_application as totalCount')
      ->limit(5)->OrderByDesc('totalCount')->get();


    //conversion rates 
    $conversionRates = job_vacancy::withCount('job_application as totalCount')
      ->limit(5)->having('totalCount', '>', 0)->OrderByDesc('totalCount')->get()
      ->map(function ($job) {
        if ($job->viewCount > 0) {
          $job->conversionRates = round($job->totalCount / $job->views_count * 100, 2);
        } else {
          $job->conversionRates = 0;
        }
      


        return $job;

      });

    $analytics = [

      'activeUsers' => $activeUsers,
      'totalJob' => $totalJob,
      'totalapplications' => $totalapplications,
      'mostAppliedJobs' => $mostAppliedJobs,
      'conversionRates' => $conversionRates
    ];

    return $analytics;
  }

  private function companyOwnerDashboard()
  {

    $company = auth()->user()->company;

    // filter active users by applying to jobs of the company
    $activeUsers = User::where(column: 'last_login_at', operator: '>=', value: now()->subDays(value: 30))
      ->where(column: 'role', operator: 'job-seeker')
      ->whereHas(relation: 'job_application', callback: function ( $query) use ($company) {
        $query->whereIn(column: 'jobVacancyID', values: $company->jobVacancies->pluck('id'));
      })
      ->count();

    // total jobs of the company
    $totalJobs = $company->jobVacancies->count();

    // total applications of the company
    $totalApplications = job_application::whereIn(column: 'jobVacancyId', values: $company->jobVacancies->pluck('id'))->count();

    // most applied jobs of the company
    $mostAppliedJobs = job_vacancy::withCount(relations: 'job_application as totalCount')
      ->whereIn(column: 'id', values: $company->jobVacancies->pluck('id'))
      ->limit(value: 5)
      ->orderByDesc(column: 'totalCount')
      ->get();


     $conversionRates = job_vacancy::withCount('job_application as totalCount')
     ->whereIn('id',$company->jobVacancies->pluck('id'))
     ->having('totalcount','>',0)
     ->limit(5)
     ->orderByDesc('totalcount')
     ->get()
     ->map(function ($job) {
        if ($job->viewCount > 0) {
          $job->conversionRates = round($job->totalCount / $job->views_count * 100, 2);
        } else {
          $job->conversionRates = 0;
        };

        return $job;

   });




    $analytics =
      [
        'activeUsers' => $activeUsers,
        'totalJob' => $totalJobs,
        'totalapplications' => $totalApplications,
        'mostAppliedJobs' => $mostAppliedJobs,
        'conversionRates' => $conversionRates

      ];

    return $analytics;

  }


}
