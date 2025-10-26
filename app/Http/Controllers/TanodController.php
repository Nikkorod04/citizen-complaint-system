<?php

namespace App\Http\Controllers;

use App\Models\UrgentRequest;
use Illuminate\Http\Request;

class TanodController extends Controller
{
    /**
     * Display the tanod dashboard
     */
    public function dashboard()
    {
        $user = auth()->user();

        $stats = [
            'pending' => UrgentRequest::where('status', 'submitted')->count(),
            'assigned' => UrgentRequest::where('tanod_id', $user->id)->where('status', 'assigned')->count(),
            'active' => UrgentRequest::where('tanod_id', $user->id)->whereIn('status', ['in_progress', 'on_the_way'])->count(),
            'resolved_today' => UrgentRequest::where('tanod_id', $user->id)->where('status', 'resolved')->whereDate('resolved_at', today())->count(),
        ];

        $activeRequests = UrgentRequest::where('tanod_id', $user->id)
            ->whereIn('status', ['assigned', 'in_progress', 'on_the_way'])
            ->latest('assigned_at')
            ->limit(5)
            ->get();

        $recentRequests = UrgentRequest::latest('submitted_at')
            ->limit(10)
            ->get();

        return view('tanod.dashboard', compact('stats', 'activeRequests', 'recentRequests'));
    }

    /**
     * Display pending (unassigned) requests
     */
    public function pending()
    {
        $pendingRequests = UrgentRequest::where('status', 'submitted')
            ->latest('submitted_at')
            ->paginate(10);

        return view('tanod.pending', compact('pendingRequests'));
    }

    /**
     * Display requests assigned to current tanod
     */
    public function assigned()
    {
        $user = auth()->user();

        // Show both 'assigned' and 'in_progress'/'on_the_way' requests
        $assignedRequests = UrgentRequest::where('tanod_id', $user->id)
            ->whereIn('status', ['assigned', 'in_progress', 'on_the_way'])
            ->latest('assigned_at')
            ->paginate(10);

        return view('tanod.assigned', compact('assignedRequests'));
    }

    /**
     * Display resolved requests
     */
    public function resolved()
    {
        $user = auth()->user();

        $resolvedRequests = UrgentRequest::where('tanod_id', $user->id)
            ->where('status', 'resolved')
            ->latest('resolved_at')
            ->paginate(15);

        return view('tanod.resolved', compact('resolvedRequests'));
    }

    /**
     * Display urgent request details
     */
    public function show(UrgentRequest $urgentRequest)
    {
        // Allow viewing if tanod is assigned or it's still unassigned
        $user = auth()->user();
        if ($urgentRequest->tanod_id && $urgentRequest->tanod_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $updates = $urgentRequest->updates()->latest()->get();

        return view('tanod.show', compact('urgentRequest', 'updates'));
    }

    /**
     * Assign a request to self
     */
    public function assign(UrgentRequest $urgentRequest)
    {
        // Can only assign unassigned requests
        if ($urgentRequest->status !== 'submitted') {
            return back()->with('error', 'This request has already been assigned');
        }

        $user = auth()->user();

        $urgentRequest->update([
            'tanod_id' => $user->id,
            'status' => 'assigned',
            'assigned_at' => now(),
        ]);

        return redirect()->route('tanod.show', $urgentRequest->id)
            ->with('success', 'Request assigned to you. Please respond to the citizen.');
    }

    /**
     * Update request status
     */
    public function updateStatus(Request $request, UrgentRequest $urgentRequest)
    {
        $user = auth()->user();

        // Verify the tanod is assigned to this request
        if ($urgentRequest->tanod_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'status' => 'required|in:in_progress,on_the_way,resolved',
            'message' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Update main request
        $updateData = [
            'status' => $validated['status'],
            'responded_at' => $urgentRequest->responded_at ?? now(),
        ];

        if ($validated['status'] === 'resolved') {
            $updateData['resolved_at'] = now();
        }

        $urgentRequest->update($updateData);

        // Log the update
        $urgentRequest->updates()->create([
            'tanod_id' => $user->id,
            'status' => $validated['status'],
            'message' => $validated['message'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
        ]);

        return back()->with('success', 'Request status updated successfully');
    }
}
