<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\CompanyCreateRequest;
use App\Http\Requests\Company\CompanyupdateRequest;
use App\Models\company;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

 

class CompanyController extends Controller
{

    public $industries = [ 'Technology', 'Finance', 'Healthcare', 'Education', 'Retail'] ;

    
 
    
    
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {   
        //Active
        $query=company::latest();
        
        //Archive
        if($request->input('archived') == 'true') 
        {
            $query->onlyTrashed();
        }

        $companies=$query->paginate(10)->onEachSide(1);
        return view('Company.index' , compact('companies'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {  
         
        $industries = $this->industries;
        return view('Company.create', compact('industries') );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest  $request)
    {

           
       
        $validated = $request->validated(); 
        // create owner
        $owner = User::create([
            'name' => $validated['owner_name'],
            'email' => $validated['owner_email'],
            'password' =>Hash::make($validated['owner_password']),
            'role' => 'company-owner',
        ]);

        

        // Return error if owner creation failed
        if (!$owner) {
            return redirect()->route('companies.create')->withErrors('Failed to create owner user. Please try again.');

        }

        // create company
         Company::create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'industry' => $validated['industry'],
            'website' => $validated['website'] ?? null,
            'ownerID' => $owner->id,       
        ]);

        

       
        return redirect()->route('companies.index')->with('success','Company created successfully');
        
        
     
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id = null)
    {

        $company = $this->getCompany($id);
       

        //$applications = job_applaction::with('user')->whereIn('jobvacancyID' ,$company->job_vacancy->pluck('id'))->get(); 
         
        return view('Company.show' , compact('company'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id = null )
    {


        $company = $this->getCompany($id);

        $industries = $this->industries;
       
        return view('Company.edit' , compact('company' ,'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyupdateRequest $request, string $id = null)
    {

        
        $validated = $request->validated(); 

        if($id)
        {
             $companies = company::findOrFail($id);
        }
        else
        {
            $companies = company::where('ownerID',auth()->user()->id)->first();
        }

        // Update company details
        $companies->update([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'industry' => $validated['industry'],
            'website' => $validated['website'] ?? null,
        ]);

        // Update owner details if provided
        $ownerData = [];
        $ownerData['name'] = $validated['owner_name'];

        if (!empty($validated['owner_password'])) {
            $ownerData['password'] = Hash::make($validated['owner_password']);
        } 

        $companies->owner->update($ownerData);

        if(auth()->user()->role == 'company-owner'){
            return redirect()->route('my-company.show')->with('success','Company update successfully!');
        }

        if($request->query('redirectToList') == 'true') {

             return redirect()->route('companies.index')->with('success','Company updated successfully');

        }
        else{
            
            return redirect()->route('companies.show', $id)->with('success','Company updated successfully');
        }
        
          
        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $companies = company::findOrFail($id);
        $companies->delete();
        return redirect()->route('companies.index')->with('success','Company archived successfully');
    }

    public function restore(string $id)
    {
        $companies = company::withTrashed()->findOrFail( $id );
        $companies->restore();
        return redirect()->route('companies.index' , ['archived' => 'true'])->with('success','Company restored successfully');
    }

    private function getCompany(string $id = null)
    {
        if ($id) {
        return company::findOrFail($id);
    }
      return company::where('ownerID' , auth()->user()->id)->first();
    }
    
}
