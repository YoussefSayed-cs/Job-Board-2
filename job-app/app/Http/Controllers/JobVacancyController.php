<?php

namespace App\Http\Controllers;

use App\Models\job_application;
use App\Models\job_vacancy;
use App\Http\Requests\AbblyJobRequest;
use App\Models\resume;
use Illuminate\Http\Request;


class JobVacancyController extends Controller
{
    public function show(string $id)
    {
        $job_vacancy = job_vacancy::findOrFail($id);
        return view('job-vacancies.show' , compact('job_vacancy'));
    }

    public function apply(string $id)
    {
        $job_vacancy = job_vacancy::findOrFail($id);
        return view('job-vacancies.apply' , compact('job_vacancy'));
    }

    public function processApplications(AbblyJobRequest $request ,string $id)
    {
        $file = $request->file('resume_file');
        $extension = $file->getClientOriginalExtension();
        $originalFileName = $file->getClientOriginalName();
        $fileName = 'resume_' . time() . '.' . $extension;

        $path = $file->storeAs('resume' , $fileName);

        $resume = resume::create(
            [
                'filename' => $originalFileName ,
                'fileUri' => $path,
                'userID' => auth()->id(),
                'contactDetails' => json_encode([
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ]) ,
                'summary' => '',
                'skills' => '',
                'experience' => '',
                'education' =>'' ,
            ]
            );

            job_application::create([
                'status' => 'pending',
                
                'aiGeneratedScore' => '0 ',
                'aiGeneratedFeedback' => '' ,
                'jobVacancyID' => $id,
                'resumeID' =>$resume->id,
                'userID' => auth()->id(),
            ]);

            return redirect()->route('job-applications.index' , $id)->with('success' , 'Applications submitted successfully');

    }
}
