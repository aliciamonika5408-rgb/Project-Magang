<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestQuotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminQuotationController extends Controller
{
    public function index(Request $request)
    {
        $query = RequestQuotation::query();

        if ($request->has('status') && $request->status != 'all' && $request->status != '') {
            $query->where('status', $request->status);
        }

        $quotations = $query->latest()->paginate(15)->withQueryString();
        return view('admin.quotations.index', compact('quotations'));
    }

    public function show($id)
    {
        $quotation = RequestQuotation::findOrFail($id);
        return view('admin.quotations.show', compact('quotation'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,approved,rejected',
        ]);

        $quotation = RequestQuotation::findOrFail($id);
        $quotation->update([
            'status' => $validated['status']
        ]);

        return redirect()->back()->with('success', 'Status quotation berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $quotation = RequestQuotation::findOrFail($id);
        
        if ($quotation->file_path) {
            Storage::disk('public')->delete($quotation->file_path);
        }
        
        $quotation->delete();

        return redirect()->route('admin.quotations.index')->with('success', 'Quotation berhasil dihapus!');
    }
}
