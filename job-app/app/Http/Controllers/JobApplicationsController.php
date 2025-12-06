<?php

namespace App\Http\Controllers;

use App\Models\job_application;
use Illuminate\Http\Request;

class JobApplicationsController extends Controller
{
       public function index()
       {
              $jobApplications = job_application::where('userID', auth()->id())->latest()->paginate(10);
              return view('job-applications.index');

       }

}
