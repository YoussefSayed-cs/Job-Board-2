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
    $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
                      ->where('role', 'applicant')
                      ->count();

    //Total job vacancies (not deleted)
    $totalJob = job_vacancy::whereNull('deleted_at')->count();

    // Total applications (not deleted)
    $totalapplications = job_application::whereNull('deleted_at')->count();

    // Most applied jobs
    $mostAppliedJobs = job_vacancy::withCount('job_application as totalCount')
      ->with('company')
      ->limit(5)
      ->orderByDesc('totalCount')
      ->get();

    //conversion rates 
    $conversionRates = job_vacancy::withCount('job_application as totalCount')
      ->limit(5)
      ->orderByDesc('totalCount')
      ->get()
      ->map(function ($job) {
        // تأكد من أن اسم العمود صحيح - غالباً 'views' أو 'view_count'
        $views = $job->views ?? $job->view_count ?? $job->views_count ?? 0;
        
        if ($views > 0) {
          $conversionRate = round(($job->totalCount / $views) * 100, 2);
        } else {
          $conversionRate = 0;
        }
        
        // أضف الحقول التي تحتاجها للعرض
        $job->views_count = $views;
        $job->conversionRates = $conversionRate;
        
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
    $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
      ->where('role', 'job-seeker')
      ->whereHas('job_application', function ($query) use ($company) {
        $query->whereIn('jobVacancyID', $company->jobVacancies->pluck('id'));
      })
      ->count();

    // total jobs of the company
    $totalJobs = $company->jobVacancies->count();

    // total applications of the company
    $totalApplications = job_application::whereIn('jobVacancyId', $company->jobVacancies->pluck('id'))->count();

    // most applied jobs of the company
    $mostAppliedJobs = job_vacancy::withCount('job_application as totalCount')
      ->whereIn('id', $company->jobVacancies->pluck('id'))
      ->limit(5)
      ->orderByDesc('totalCount')
      ->get();

    $conversionRates = job_vacancy::withCount('job_application as totalCount')
      ->whereIn('id', $company->jobVacancies->pluck('id'))
      ->having('totalCount', '>', 0)
      ->limit(5)
      ->orderByDesc('totalCount')
      ->get()
      ->map(function ($job) {
        // تأكد من أن اسم العمود صحيح
        $views = $job->views ?? $job->view_count ?? $job->views_count ?? 0;
        
        if ($views > 0) {
          $conversionRate = round(($job->totalCount / $views) * 100, 2);
        } else {
          $conversionRate = 0;
        }
        
        $job->views_count = $views;
        $job->conversionRates = $conversionRate;
        
        return $job;
      });

    $analytics = [
      'activeUsers' => $activeUsers,
      'totalJob' => $totalJobs,
      'totalapplications' => $totalApplications,
      'mostAppliedJobs' => $mostAppliedJobs,
      'conversionRates' => $conversionRates
    ];

    return $analytics;
  }
}