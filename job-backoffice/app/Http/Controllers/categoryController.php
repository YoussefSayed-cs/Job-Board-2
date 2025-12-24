<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\JobCategory\JobCategoryCreateRequest;
use App\Http\Requests\JobCategory\JobCategoryupdateRequest;

use App\Models\job_category;


class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        //Active
        $query=job_category::latest();
        
        //Archive
        if($request->input('archived') == 'true') 
        {
            $query->onlyTrashed();
        }

        $job_categories=$query->paginate(10)->onEachSide(1);
        return view('Job Category.index' , compact('job_categories'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Job Category.create' );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCategoryCreateRequest $request)
    {
       
        $validated = $request->validated(); 
        job_category::create($validated);
        return redirect()->route('job-categories.index')->with('success','Job category created successfully');
        
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = job_category::findOrFail($id);
        return view('Job Category.edit' , compact('category') );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCategoryupdateRequest $request, string $id)
    {
        $validated = $request->validated(); 
        $category = job_category::findOrFail($id);
        $category->update($validated);  
        return redirect()->route('job-categories.index')->with('success','Job category updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = job_category::findOrFail($id);
        $category->delete();
        return redirect()->route('job-categories.index')->with('success','Job category archived successfully');
    }

    public function restore(string $id)
    {
        $category = job_category::withTrashed()->findOrFail( $id );
        $category->restore();
        return redirect()->route('job-categories.index' , ['archived' => 'true'])->with('success','Job category restored successfully');
    }
}
