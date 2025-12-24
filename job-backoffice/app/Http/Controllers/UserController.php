<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use App\Http\Requests\User\UserupdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query =User::latest();


    $search = $request->search;
     if ($search) {
    $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%$search%")
          ->orWhere('email', 'like', "%$search%");
    });
    }


        if( $request->input('archived') == 'true' )
        {
            $query->onlyTrashed();
        }
        $users = $query->paginate(10)->onEachSide(2);
        return view("User.index" ,compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::findOrFail($id);
        return view("User.edit", compact("users"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserupdateRequest $request, string $id)
    {
        $users = User::findOrFail($id);
        $users->update([
            'password' => Hash::make($request->input('password')),
        ]);
        
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = User::findOrFail($id);
        $users->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function restore(string $id)
    {
        $users = User::withTrashed()->findOrFail($id);
        $users->restore();
        return redirect()->route('users.index')->with('success', 'User restored successfully.');
    }
}
