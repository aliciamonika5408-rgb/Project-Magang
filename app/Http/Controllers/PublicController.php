<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\OtherService;
use App\Models\Project;
use App\Models\Client;
use App\Models\CompanySetting;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $services = Service::latest()->take(6)->get();
        $otherServices = OtherService::latest()->get();
        $projects = Project::with('images')->latest()->take(6)->get();
        $clients = Client::latest()->get();
        $stats = CompanySetting::pluck('value', 'key')->toArray();

        return view('welcome', compact('services', 'otherServices', 'projects', 'clients', 'stats'));
    }

    public function services()
    {
        $services = Service::latest()->paginate(6);
        $otherServices = OtherService::latest()->get();
        return view('public.services.index', compact('services', 'otherServices'));
    }

    public function serviceDetail($slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();
        $relatedServices = Service::where('id', '!=', $service->id)->take(3)->get();
        return view('public.services.detail', compact('service', 'relatedServices'));
    }

    public function projects(Request $request)
    {
        $query = Project::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && $request->category != 'all' && $request->category != '') {
            $query->where('category', $request->category);
        }

        $projects = $query->with('images')->latest()->paginate(9)->withQueryString();
        
        // Get all unique categories for filters
        $categories = Project::select('category')->distinct()->pluck('category');

        return view('public.projects.index', compact('projects', 'categories'));
    }

    public function projectDetail($slug)
    {
        $project = Project::with('images')->where('slug', $slug)->firstOrFail();
        $relatedProjects = Project::where('category', $project->category)
            ->where('id', '!=', $project->id)
            ->take(3)
            ->get();
            
        return view('public.projects.detail', compact('project', 'relatedProjects'));
    }

    public function clients()
    {
        $clients = Client::latest()->get();
        return view('public.clients', compact('clients'));
    }

    public function contact()
    {
        return view('public.contact');
    }
}
