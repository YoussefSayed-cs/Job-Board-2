<?php

namespace App\Http\Controllers;

use App\Notifications\NewJobApplicationNotification;

use App\Models\User;

use App\Models\job_application;
use Illuminate\Http\Request;

class applicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // الأساس: أحدث التطبيقات أولاً
        $query = job_application::latest();

        // فلترة حسب صاحب الشركة
        if (auth()->user()->role == 'company-owner') {
            $query->whereHas('jobVacancy', function ($q) {
                $q->where('companyID', auth()->user()->company->id);
            });
        }

        // فلترة حسب Job Vacancy لو جاي من إشعار
        if ($request->has('job')) {
            $query->where('jobVacancyID', $request->input('job'));
        }

        // فلترة الأرشيف
        if ($request->input('archived') == 'true') {
            $query->onlyTrashed();
        }

        // Pagination
        $job_applications = $query->paginate(10)->onEachSide(1);

        return view('JobApplication.index', compact('job_applications'));
    }


    public function show(string $id)
    {
        $job_application = job_application::withTrashed()->findOrFail($id);
        return view('JobApplication.show', compact('job_application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $job_application = job_application::findOrFail($id);
        return view('JobApplication.edit', compact('job_application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $job_application = job_application::findOrFail($id);

        $job_application->update([
            'status' => $request->input('status')
        ]);

        if ($request->query('redirectToList') == 'false') {

            return redirect()->route('job-applications.show', $job_application->id)->with('success', 'Job application updated successfully.');
        }

        return redirect()->route('job-applications.index')->with('success', 'Job application updated successfully.');
    }

    public function store(Request $request)
{
    $jobApplication = job_application::create([
        'jobVacancyID' => $request->jobVacancyID,
        'userID'       => auth()->id(),
        'status'       => 'pending',
    ]);

    // صاحب الشركة
    $owner = $jobApplication
        ->jobVacancy
        ->company
        ->Owner;

    // إرسال Notification
    $owner->notify(
        new NewJobApplicationNotification($jobApplication, route('job-applications.show', $jobApplication->id))
    );

    return back()->with('success', 'Application sent successfully');
}







    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $job_application = job_application::findOrFail($id);
        $job_application->delete();

        return redirect()->route('job-applications.index')->with('success', 'Job application archived successfully.');
    }

    public function restore(string $id)
    {
        $job_application = job_application::withTrashed()->findOrFail($id);
        $job_application->restore();

        return redirect()->route('job-applications.index')->with('success', 'Job application restored successfully.');
    }
}
