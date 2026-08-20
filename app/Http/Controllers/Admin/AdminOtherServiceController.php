<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OtherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminOtherServiceController extends Controller
{
    public function index()
    {
        $otherServices = OtherService::latest()->paginate(10);
        return view('admin.other_services.index', compact('otherServices'));
    }

    public function create()
    {
        return view('admin.other_services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        OtherService::create($validated);

        return redirect()->route('admin.home-editor', ['tab' => 'other-services'])->with('success', 'Layanan Lainnya berhasil ditambahkan!');
    }

    public function edit(OtherService $otherService)
    {
        return view('admin.other_services.edit', compact('otherService'));
    }

    public function update(Request $request, OtherService $otherService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $otherService->update($validated);

        return redirect()->route('admin.home-editor', ['tab' => 'other-services'])->with('success', 'Layanan Lainnya berhasil diupdate!');
    }

    public function destroy(OtherService $otherService)
    {
        if ($otherService->image) {
            Storage::disk('public')->delete($otherService->image);
        }
        $otherService->delete();

        return redirect()->route('admin.home-editor', ['tab' => 'other-services'])->with('success', 'Layanan Lainnya berhasil dihapus!');
    }
}
