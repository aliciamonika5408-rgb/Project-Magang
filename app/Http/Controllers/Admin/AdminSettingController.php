<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = CompanySetting::pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'years_experience' => 'required|string|max:50',
            'projects_completed' => 'required|string|max:50',
            'experts_count' => 'required|string|max:50',
            'work_accidents' => 'required|string|max:50',
        ]);

        foreach ($validated as $key => $value) {
            CompanySetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Statistik perusahaan berhasil diperbarui!');
    }
}
