<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbblyJobRequest;
use App\Models\job_application;
use App\Models\job_vacancy;
use App\Models\resume;
use App\Models\User;
use App\Notifications\newJobApply;
use App\Services\ResumesAnalysisServices;
use Illuminate\Support\Facades\Log;

class JobVacancyController extends Controller
{
    protected ResumesAnalysisServices $resumeService;

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

        // ✅ default structure (مهم جدًا)
        $extracted = [
            'summary' => '',
            'skills' => '',
            'experience' => '',
            'education' => '',
        ];

        /*
        |------------------------------------------------------------------
        | EXISTING RESUME
        |------------------------------------------------------------------
        */
        if (str_starts_with($request->resume_option, 'existing_')) {

            $existingId = str_replace('existing_', '', $request->resume_option);

            $resume = resume::where('id', $existingId)
                ->where('userID', auth()->id())
                ->first();

            if (!$resume) {
                return back()->withErrors(['resume_option' => 'Invalid resume selected']);
            }

            $resumeID = $resume->id;

            $extracted = [
                'summary' => $resume->summary ?? '',
                'skills' => $resume->skills ?? '',
                'experience' => $resume->experience ?? '',
                'education' => $resume->education ?? '',
            ];
        }

        /*
        |------------------------------------------------------------------
        | NEW RESUME
        |------------------------------------------------------------------
        */
        elseif ($request->resume_option === 'new_resume') {

            $file = $request->file('resume_file');
            $fileName = 'resume_' . time() . '.pdf';
            $path = $file->storeAs('resume', $fileName, 'cloud');

            // ✅ AI extraction (safe)
            try {
                $extracted = $this->resumeService->extractResumeInformation($path);
            } catch (\Throwable $e) {
                Log::warning('AI extraction skipped: ' . $e->getMessage());
            }

            $resume = resume::create([
                'filename' => $file->getClientOriginalName(),
                'fileUri' => $path,
                'userID' => auth()->id(),
                'contactDetails' => json_encode([
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ]),
                'summary' => $extracted['summary'] ?? '',
                'skills' => $extracted['skills'] ?? '',
                'experience' => $extracted['experience'] ?? '',
                'education' => $extracted['education'] ?? '',
            ]);

            $resumeID = $resume->id;
        }

        else {
            return back()->withErrors(['resume_option' => 'Choose a resume option']);
        }

        /*
        |------------------------------------------------------------------
        | AI EVALUATION (OPTIONAL)
        |------------------------------------------------------------------
        */
        try {
            $evaluation = $this->resumeService->analyzeResume($job_vacancy, $extracted);
        } catch (\Throwable $e) {
            Log::warning('AI evaluation skipped: ' . $e->getMessage());

            $evaluation = [
                'aiGeneratedScore' => 0,
                'aiGeneratedFeedback' =>
                    'AI evaluation is temporarily unavailable.',
            ];
        }

        $application = job_application::create([
            'status' => 'pending',
            'aiGeneratedScore' => $evaluation['aiGeneratedScore'] ?? 0,
            'aiGeneratedFeedback' =>
                $evaluation['aiGeneratedFeedback'] ?? 'No AI feedback',
            'jobVacancyID' => $job_vacancy->id,
            'resumeID' => $resumeID,
            'userID' => auth()->id(),
        ]);

        /*
        |------------------------------------------------------------------
        | NOTIFICATIONS
        |------------------------------------------------------------------
        */
        $notification = new newJobApply(
            auth()->user(),
            $job_vacancy,
            $application,
            $application->id
        );

        // Company owner
        $job_vacancy->company->Owner->notify($notification);

        // Admins
        User::where('role', 'admin')->each(
            fn ($admin) => $admin->notify($notification)
        );

        return redirect()
            ->route('job-applications.index')
            ->with('success', 'Application submitted successfully!');
    }
}
