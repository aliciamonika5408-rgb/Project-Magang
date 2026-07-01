<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'client_name' => 'nullable|string|max:255',
            'budget' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $validated['slug'] = Str::slug($request->title);
        $count = Project::where('slug', $validated['slug'])->count();
        if ($count > 0) {
            $validated['slug'] = $validated['slug'] . '-' . time();
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $validated['image'] = $path;
        }

        $project = Project::create($validated);

        // Upload Gallery Images if present
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $galPath = $file->store('projects/gallery', 'public');
                ProjectImage::create([
                    'project_id' => $project->id,
                    'image_path' => $galPath
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil dibuat!');
    }

    public function edit(Project $project)
    {
        $project->load('images');
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'client_name' => 'nullable|string|max:255',
            'budget' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->title !== $project->title) {
            $validated['slug'] = Str::slug($request->title);
            $count = Project::where('slug', $validated['slug'])->where('id', '!=', $project->id)->count();
            if ($count > 0) {
                $validated['slug'] = $validated['slug'] . '-' . time();
            }
        }

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $path = $request->file('image')->store('projects', 'public');
            $validated['image'] = $path;
        }

        $project->update($validated);

        // Upload new gallery items
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $galPath = $file->store('projects/gallery', 'public');
                ProjectImage::create([
                    'project_id' => $project->id,
                    'image_path' => $galPath
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil diupdate!');
    }

    public function destroy(Project $project)
    {
        // Delete primary image
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        // Delete gallery images
        $project->load('images');
        foreach ($project->images as $img) {
            Storage::disk('public')->delete($img->image_path);
            $img->delete();
        }

        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil dihapus!');
    }

    // AJAX helper to delete specific project gallery item
    public function deleteGalleryImage($id)
    {
        $image = ProjectImage::findOrFail($id);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }
}
