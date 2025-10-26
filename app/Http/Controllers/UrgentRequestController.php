<?php

namespace App\Http\Controllers;

use App\Models\UrgentRequest;
use Illuminate\Http\Request;

class UrgentRequestController extends Controller
{
    /**
     * Display list of citizen's urgent requests
     */
    public function index()
    {
        $user = auth()->user();
        $urgentRequests = $user->submittedUrgentRequests()
            ->latest('submitted_at')
            ->paginate(10);

        return view('urgent-requests.index', compact('urgentRequests'));
    }

    /**
     * Show form to create new urgent request
     */
    public function create()
    {
        return view('urgent-requests.create');
    }

    /**
     * Store a new urgent request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'location' => 'required|string|max:255',
            'category' => 'required|in:medical,accident,fire,security,disaster,other',
            'priority' => 'required|in:high,urgent',
        ]);

        $user = auth()->user();
        $validated['citizen_id'] = $user->id;
        $validated['status'] = 'submitted';
        $validated['submitted_at'] = now();

        $urgentRequest = UrgentRequest::create($validated);

        return redirect()->route('urgent-requests.show', $urgentRequest->id)
            ->with('success', 'Urgent request submitted successfully. Tanods have been notified.');
    }

    /**
     * Show urgent request details
     */
    public function show(UrgentRequest $urgentRequest)
    {
        // Verify the citizen owns this request
        if ($urgentRequest->citizen_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $updates = $urgentRequest->updates()->latest()->get();

        return view('urgent-requests.show', compact('urgentRequest', 'updates'));
    }

    /**
     * Cancel an urgent request
     */
    public function cancel(UrgentRequest $urgentRequest)
    {
        // Verify the citizen owns this request
        if ($urgentRequest->citizen_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Can only cancel if not yet resolved
        if ($urgentRequest->status === 'resolved') {
            return back()->with('error', 'Cannot cancel a resolved request');
        }

        $urgentRequest->update(['status' => 'cancelled']);

        return redirect()->route('urgent-requests.index')
            ->with('success', 'Urgent request cancelled');
    }

    /**
     * Track urgent request status
     */
    public function track(UrgentRequest $urgentRequest)
    {
        // Verify the citizen owns this request
        if ($urgentRequest->citizen_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $updates = $urgentRequest->updates()->latest()->get();

        return view('urgent-requests.show', compact('urgentRequest', 'updates'));
    }

    /**
     * Delete urgent request (not used in regular flow, but for completeness)
     */
    public function destroy(UrgentRequest $urgentRequest)
    {
        if ($urgentRequest->citizen_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $urgentRequest->delete();

        return redirect()->route('urgent-requests.index')
            ->with('success', 'Urgent request deleted');
    }
}
