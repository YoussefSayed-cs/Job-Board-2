<?php

namespace App\Http\Controllers;

use App\Models\job_vacancy;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $search = $request->search;
    $filter = $request->filter;

    $query = job_vacancy::query();

    // Search only
    if ($search && !$filter) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%$search%")
              ->orWhere('location', 'like', "%$search%")
              ->orWhereHas('company', function ($c) use ($search) {
                  $c->where('name', 'like', "%$search%");
              });
        });
    }

    // Filter only
    if ($filter && !$search) {
        $query->where('type', $filter);
    }

    // Search + Filter
    if ($search && $filter) {
        $query->where('type', $filter)
              ->where(function ($q) use ($search) {
                  $q->where('title', 'like', "%$search%")
                    ->orWhere('location', 'like', "%$search%")
                    ->orWhereHas('company', function ($c) use ($search) {
                        $c->where('name', 'like', "%$search%");
                    });
              });
    }

    $jobs = $query->latest()->paginate(10)->withQueryString();

    return view('dashboard', compact('jobs'));
}


   
}
