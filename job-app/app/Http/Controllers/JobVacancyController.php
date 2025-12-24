<?php

namespace App\Http\Controllers;

use App\Models\job_application;
use App\Models\job_vacancy;
use App\Http\Requests\AbblyJobRequest;
use App\Models\resume;
use App\Services\ResumesAnalysisServices;
use Illuminate\Http\Request;
class JobVacancyController extends Controller
{
    protected $resumeService;

    public function __construct(ResumesAnalysisServices $resumeService)
    {
        $this->resumeService = $resumeService;
    }

    public function show(string $id)
    {
        $job_vacancy = job_vacancy::findOrFail($id);
        return view('job-vacancies.show', compact('job_vacancy'));
    }

    public function apply(string $id)
    {
        $job_vacancy = job_vacancy::findOrFail($id);
        $resumes = auth()->user()->resume;
        return view('job-vacancies.apply', compact('job_vacancy', 'resumes'));
    }

    public function processApplications(AbblyJobRequest $request, string $id)
    {
        $job_vacancy = job_vacancy::findOrFail($id);
        $resumeID = null;
        $extracted = [];

        // EXISTING RESUME
        if (str_starts_with($request->resume_option, 'existing_')) {

            $existingId = str_replace('existing_', '', $request->resume_option);

            $resume = resume::where('id', $existingId)
                ->where('userID', auth()->id())
                ->first();

            if (!$resume) {
                return back()->withErrors(['resume_option' => 'Invalid resume selected']);
            }

            $resumeID = $resume->id;

            // extract existing resume data for AI evaluation
            $extracted = [
                'summary' => $resume->summary,
                'skills' => $resume->skills,
                'experience' => $resume->experience,
                'education' => $resume->education,
            ];
        }

        // NEW RESUME
        elseif ($request->resume_option === 'new_resume') {

            if (!$request->hasFile('resume_file')) {
                return back()->withErrors(['resume_file' => 'Please upload a PDF']);
            }

            $file = $request->file('resume_file');
            if ($file->getClientOriginalExtension() !== 'pdf') {
                return back()->withErrors(['resume_file' => 'Only PDF files allowed']);
            }

            $fileName = 'resume_' . time() . '.pdf';
            $path = $file->storeAs('resume', $fileName);

            // Extract AI Data
            $extracted = $this->resumeService->extractResumeInformation($path);

            $newResume = resume::create([
                'filename' => $file->getClientOriginalName(),
                'fileUri' => $path,
                'userID' => auth()->id(),
                'contactDetails' => json_encode([
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ]),
                'summary' => $extracted['summary'],
                'skills' => $extracted['skills'],
                'experience' => $extracted['experience'],
                'education' => $extracted['education'],
            ]);

            $resumeID = $newResume->id;
        } else {
            return back()->withErrors(['resume_option' => 'Choose a resume option']);
        }

        // AI EVALUATION
        $evaluation = $this->resumeService->analyzeResume($job_vacancy, $extracted);

        $application = job_application::create([
            'status' => 'pending',
            'aiGeneratedScore' => $evaluation['aiGeneratedScore'],
            'aiGeneratedFeedback' => $evaluation['aiGeneratedFeedback'],
            'jobVacancyID' => $id,
            'resumeID' => $resumeID,
            'userID' => auth()->id(),
        ]);

        
        return redirect()
            ->route('job-applications.index')
            ->with('success', 'Application submitted successfully!');
    }
}
