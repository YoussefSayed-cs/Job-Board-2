<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\job_category;
use App\Models\job_vacancy;
 
use Illuminate\Http\Request;
use App\Http\Requests\JobVacancy\JobVacancyCreateRequest;
use App\Http\Requests\JobVacancy\JobVacancyUpdateRequest;  


class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         //Active
        $query=job_vacancy::latest();

        if(auth()->user()->role == 'company-owner')
        {
            $query->where('companyID',auth()->user()->company->id);
        }
        
        //Archive
        if($request->input('archived') == 'true') 
        {
            $query->onlyTrashed();
        }

        $vacancies=$query->paginate(10)->onEachSide(1);
        return view('Job Vacancy.index', compact('vacancies'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = company::all();
        $jobCategories = job_category::all();
        return view('Job Vacancy.create', compact('companies', 'jobCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobVacancyCreateRequest $request)
    {
        $validated = $request->validated(); 
        job_vacancy::create( $validated);
        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vacancy = job_vacancy::findOrFail($id);
        return view('Job Vacancy.show', compact('vacancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vacancy = Job_Vacancy::findOrFail($id);
        $companies = company::all();
        $jobCategories = job_category::all();
        return view('Job Vacancy.edit', compact('vacancy', 'companies', 'jobCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyUpdateRequest $request, string $id)
    {
        
        $validated = $request->validated();
        $vacancy = job_vacancy::findOrFail($id);
        $vacancy->update( $validated );

        if($request->query('redirectToList') == 'false')
        {
             return redirect()->route('job-vacancies.show', $vacancy->id)->with('success','Job vacancy updated successfully');
        }
        else
        {
            return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy updated successfully.');
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vacancy = Job_vacancy::findOrFail($id);
        $vacancy->delete();
        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy archived successfully.');
    }

    public function restore(string $id)
    {
        $vacancy = job_vacancy::withTrashed()->findOrFail($id);
        $vacancy->restore();
        return redirect()->route('job-vacancies.index',['archived' => 'true'])->with('success', 'Job vacancy restored successfully.');
    }
}
