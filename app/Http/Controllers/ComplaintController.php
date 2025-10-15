<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\ComplaintCategory;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complaints = Complaint::where('user_id', auth()->id())
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('complaints.index', compact('complaints'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ComplaintCategory::active()->get();
        return view('complaints.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'complaint_category_id' => 'required|exists:complaint_categories,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'location' => 'nullable|string|max:255',
            'evidence.*' => 'nullable|file|mimes:jpeg,png,jpg,mp4,mpeg,mov|max:20480', // 20MB max
        ]);

        $complaint = Complaint::create([
            'user_id' => auth()->id(),
            'complaint_category_id' => $validated['complaint_category_id'],
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'location' => $validated['location'] ?? null,
            'status' => 'pending',
        ]);

        // Handle evidence upload
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $complaint->addMedia($file)->toMediaCollection('evidence');
            }
        }

        return redirect()->route('complaints.show', $complaint)
            ->with('success', 'Complaint filed successfully! Complaint Number: ' . $complaint->complaint_number);
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        // Ensure user can only view their own complaints
        if ($complaint->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $complaint->load(['category', 'validator', 'resolver']);

        return view('complaints.show', compact('complaint'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        // Only allow editing if complaint is still pending
        if ($complaint->status !== 'pending') {
            return back()->with('error', 'Cannot edit complaint that has been processed.');
        }

        if ($complaint->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $categories = ComplaintCategory::active()->get();
        return view('complaints.edit', compact('complaint', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        if ($complaint->status !== 'pending') {
            return back()->with('error', 'Cannot edit complaint that has been processed.');
        }

        if ($complaint->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'complaint_category_id' => 'required|exists:complaint_categories,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'location' => 'nullable|string|max:255',
            'evidence.*' => 'nullable|file|mimes:jpeg,png,jpg,mp4,mpeg,mov|max:20480',
        ]);

        $complaint->update([
            'complaint_category_id' => $validated['complaint_category_id'],
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'location' => $validated['location'] ?? null,
        ]);

        // Handle new evidence upload
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $complaint->addMedia($file)->toMediaCollection('evidence');
            }
        }

        return redirect()->route('complaints.show', $complaint)
            ->with('success', 'Complaint updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        if ($complaint->status !== 'pending') {
            return back()->with('error', 'Cannot delete complaint that has been processed.');
        }

        if ($complaint->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $complaint->delete();

        return redirect()->route('complaints.index')
            ->with('success', 'Complaint deleted successfully.');
    }
}
