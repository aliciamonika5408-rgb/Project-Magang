<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\OtherService;
use App\Models\Project;
use App\Models\Client;
use App\Models\CompanySetting;
use App\Models\RequestQuotation;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::latest()->get();
        $otherServices = OtherService::latest()->get();
        $projects = Project::latest()->get();
        $clients = Client::latest()->get();
        $stats = CompanySetting::pluck('value', 'key')->toArray();
        $quotations = RequestQuotation::latest()->paginate(10);

        $activeTab = $request->get('tab', 'services');

        return view('admin.home_editor', compact(
            'services',
            'otherServices',
            'projects',
            'clients',
            'stats',
            'quotations',
            'activeTab'
        ));
    }
}
