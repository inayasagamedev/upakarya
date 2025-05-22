<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Job;

class JobController extends Controller
{
    use AuthorizesRequests;

    // @desc Show all job listings
    // @route GET /jobs
    public function index(): View
    {
        $jobs = Job::latest()->paginate(9);
        return view('jobs.index')->with('jobs', $jobs);
    }

    // @desc Show create job form
    // @route GET /jobs/create
    public function create()
    {
        return view('/jobs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validateData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|integer',
            'tags' => 'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'nullable|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'company_website' => 'nullable|url'
        ]);

        // Hardcoded user ID
        $user_data = Auth::user();
        $validateData['user_id'] = $user_data->id;

        // Check for image
        if($request->hasFile('company_logo')){
            // Store the file and get path
            $path = $request->file('company_logo')->store('logos','public');

            // Add path to validated data
            $validateData['company_logo'] = $path;
        }

        // Submit to database
        Job::create($validateData);

        return redirect()->route('jobs.index')->with('success', 'Job listing created successfully!');
    }

    public function show(Job $job): View
    {
        return view('jobs.show')->with('job', $job);
    }

    public function edit(Job $job): View
    {
        // Check if user is authorized
        $this->authorize('update', $job);
        
        return view('jobs.edit')->with('job', $job);
    }

    public function update(Request $request, Job $job): string
    {
        // Check if user is authorized
        $this->authorize('update', $job);

        $validateData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|integer',
            'tags' => 'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'nullable|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'company_website' => 'nullable|url'
        ]);

        // Check for image
        if($request->hasFile('company_logo')){
            // Delete old logo
            Storage::delete('public/logos/' . basename($job->company_logo));

            // Store the file and get path
            $path = $request->file('company_logo')->store('logos','public');

            // Add path to validated data
            $validateData['company_logo'] = $path;
        }

        // Submit to database
        $job->update($validateData);

        return redirect()->route('jobs.index')->with('success', 'Job listing updated successfully!');
    }

    public function destroy(Job $job): RedirectResponse
    {
        // Check if user is authorized
        $this->authorize('delete', $job);

        // If logo, then delete it
        if($job->company_logo){
            Storage::delete('public/logos/' . $job->company_logo);
        }

        $job->delete();

        // Check if request came from the dashboard
        if(request()->query('from') == 'dashboard'){
            return redirect()->route('dashboard')->with('success', 'Job listing deleted successfully!');
        }

        return redirect()->route('jobs.index')->with('success', 'Job listing deleted successfully!');
    }

    // @desc    Search job listings
    // @route   GET /jobs/search
    public function search(Request $request): View
    {
        $keywords = strtolower($request->input('keywords'));
        $location = strtolower($request->input('location'));

        $query = Job::query();

        if($keywords){
            $query->where(function($q) use ($keywords){
                $q->whereRaw('LOWER(title) like ?', ['%' . $keywords . '%'])
                    ->orwhereRaw('LOWER(description) like ?', ['%' . $keywords . '%'])
                    ->orwhereRaw('LOWER(tags) like ?', ['%' . $keywords . '%']);
            });
        }

        if($location){
            $query->where(function($q) use ($location){
                $q->whereRaw('LOWER(address) like ?', ['%' . $location . '%'])
                    ->orwhereRaw('LOWER(city) like ?', ['%' . $location . '%'])
                    ->orwhereRaw('LOWER(state) like ?', ['%' . $location . '%'])
                    ->orwhereRaw('LOWER(zipcode) like ?', ['%' . $location . '%']);
            });
        }

        $jobs = $query->paginate(9);

        return view('jobs.index')->with('jobs', $jobs);
    }
}
