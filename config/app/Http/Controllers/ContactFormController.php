<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $validated['is_read'] = false;

        Contact::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesan Anda berhasil dikirim! Kami sangat menghargai masukan Anda dan akan membalas secepatnya.'
            ]);
        }

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim! Kami sangat menghargai masukan Anda dan akan membalas secepatnya.');
    }
}
