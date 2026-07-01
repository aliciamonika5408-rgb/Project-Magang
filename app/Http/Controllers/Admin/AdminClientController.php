<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->paginate(15);
        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'website_url' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('clients', 'public');
            $validated['logo_path'] = $path;
        }

        unset($validated['logo']);
        Client::create($validated);

        return redirect()->route('admin.clients.index')->with('success', 'Klien berhasil ditambahkan!');
    }

    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'website_url' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('logo')) {
            if ($client->logo_path) {
                Storage::disk('public')->delete($client->logo_path);
            }
            $path = $request->file('logo')->store('clients', 'public');
            $validated['logo_path'] = $path;
        }

        unset($validated['logo']);
        $client->update($validated);

        return redirect()->route('admin.clients.index')->with('success', 'Klien berhasil diupdate!');
    }

    public function destroy(Client $client)
    {
        if ($client->logo_path) {
            Storage::disk('public')->delete($client->logo_path);
        }
        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Klien berhasil dihapus!');
    }
}
