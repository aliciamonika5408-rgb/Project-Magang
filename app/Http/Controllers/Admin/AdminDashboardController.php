<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Project;
use App\Models\Client;
use App\Models\RequestQuotation;
use App\Models\Contact;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalServices = Service::count();
        $totalProjects = Project::count();
        $totalClients = Client::count();
        
        $totalQuotations = RequestQuotation::count();
        $pendingQuotations = RequestQuotation::where('status', 'pending')->count();
        
        $totalContacts = Contact::count();
        $unreadContacts = Contact::where('is_read', false)->count();

        $recentQuotations = RequestQuotation::latest()->take(5)->get();
        $recentContacts = Contact::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalServices',
            'totalProjects',
            'totalClients',
            'totalQuotations',
            'pendingQuotations',
            'totalContacts',
            'unreadContacts',
            'recentQuotations',
            'recentContacts'
        ));
    }
}
