<?php

namespace App\Http\Controllers;

use App\Models\RequestQuotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuotationController extends Controller
{
    public function index()
    {
        return view('public.quotation');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:20',
            'project_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'building_area' => 'nullable|string|max:100',
            'budget' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip,rar|max:10240', // 10MB Max
        ]);

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('quotations', 'public');
            $validated['file_path'] = $path;
        }

        unset($validated['attachment']);
        $validated['status'] = 'pending';

        RequestQuotation::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Request quotation Anda berhasil dikirim! Tim kami akan segera menghubungi Anda melalui email atau WhatsApp.'
            ]);
        }

        return redirect()->back()->with('success', 'Request quotation Anda berhasil dikirim! Tim kami akan segera menghubungi Anda melalui email atau WhatsApp.');
    }
}
