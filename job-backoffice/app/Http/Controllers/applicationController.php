<?php

namespace App\Http\Controllers;

use App\Models\job_application;
use Illuminate\Http\Request;

class applicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         //Active
        $query=job_application::latest();

        if(auth()->user()->role == 'company-owner')
        {
            $query->whereHas('JobVacancy', function($query){
            $query->where('companyID',auth()->user()->company->id);
            });
        }
        
        //Archive
        if($request->input('archived') == 'true') 
        {
            $query->onlyTrashed();
        }

        $job_applications=$query->paginate(10)->onEachSide(1);

      
        return view('JobApplication.index', compact('job_applications'));

    }

    public function show(string $id)
    {
        $job_application=job_application::withTrashed()->findOrFail($id);
        return view('JobApplication.show', compact('job_application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $job_application=job_application::findOrFail($id);
        return view('JobApplication.edit', compact('job_application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $job_application=job_application::findOrFail($id);

        $job_application->update([
            'status' => $request->input('status')
        ]);

        if($request->query('redirectToList') =='false') {
             
        return redirect()->route('job-applications.show', $job_application->id)->with('success', 'Job application updated successfully.');
        }

        return redirect()->route('job-applications.index')->with('success', 'Job application updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $job_application=job_application::findOrFail($id);
        $job_application->delete();

        return redirect()->route('job-applications.index')->with('success', 'Job application archived successfully.');
    }

    public function restore(string $id)
    {
        $job_application=job_application::withTrashed()->findOrFail($id);
        $job_application->restore();

        return redirect()->route('job-applications.index')->with('success', 'Job application restored successfully.');
    }
}
