<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\User;
use App\Models\ComplaintCategory;
use Barryvdh\DomPDF\Facade\Pdf;

class CaptainController extends Controller
{
    /**
     * Display the captain dashboard
     */
    public function dashboard()
    {
        $validatedComplaints = Complaint::where('status', 'validated')
            ->with(['user', 'category'])
            ->latest()
            ->take(10)
            ->get();

        $stats = [
            'total_complaints' => Complaint::count(),
            'validated_pending' => Complaint::where('status', 'validated')->count(),
            'in_progress' => Complaint::where('status', 'in_progress')->count(),
            'resolved_this_month' => Complaint::where('status', 'resolved')
                ->whereMonth('resolved_at', now()->month)
                ->count(),
            'total_citizens' => User::where('role', 'citizen')->where('verification_status', 'approved')->count(),
        ];

        // Category breakdown
        $categoryStats = Complaint::selectRaw('complaint_category_id, count(*) as total')
            ->groupBy('complaint_category_id')
            ->with('category')
            ->get();

        return view('captain.dashboard', compact('validatedComplaints', 'stats', 'categoryStats'));
    }

    /**
     * Display all complaints
     */
    public function complaints(Request $request)
    {
        $query = Complaint::with(['user', 'category', 'validator']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('complaint_category_id', $request->category);
        }

        $complaints = $query->latest()->paginate(15);
        $categories = ComplaintCategory::active()->get();

        return view('captain.complaints', compact('complaints', 'categories'));
    }

    /**
     * Show a specific complaint
     */
    public function show(Complaint $complaint)
    {
        $complaint->load(['user', 'category', 'validator', 'resolver']);

        return view('captain.complaint-show', compact('complaint'));
    }

    /**
     * Resolve a complaint
     */
    public function resolve(Request $request, Complaint $complaint)
    {
        $request->validate([
            'captain_resolution' => 'required|string|max:2000',
            'recommendation' => 'nullable|string|max:2000',
        ]);

        $complaint->update([
            'status' => 'resolved',
            'captain_resolution' => $request->captain_resolution,
            'recommendation' => $request->recommendation,
            'resolved_at' => now(),
            'resolved_by' => auth()->id(),
        ]);

        return redirect()->route('captain.complaints')
            ->with('success', 'Complaint resolved successfully!');
    }

    /**
     * Mark complaint as in progress
     */
    public function markInProgress(Complaint $complaint)
    {
        $complaint->update([
            'status' => 'in_progress',
        ]);

        return redirect()->back()
            ->with('success', 'Complaint marked as in progress!');
    }

    /**
     * Display analytics page
     */
    public function analytics()
    {
        // Monthly trends for the past 12 months
        $monthlyTrends = Complaint::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as total')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Status breakdown
        $statusBreakdown = Complaint::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => $item->count];
            });

        // Category performance
        $categoryPerformance = ComplaintCategory::withCount([
            'complaints',
            'complaints as resolved_count' => function ($query) {
                $query->where('status', 'resolved');
            },
            'complaints as pending_count' => function ($query) {
                $query->whereIn('status', ['pending', 'validated', 'in_progress']);
            }
        ])->get();

        // Average resolution time (in days)
        $avgResolutionTime = Complaint::whereNotNull('resolved_at')
            ->selectRaw('AVG(DATEDIFF(resolved_at, created_at)) as avg_days')
            ->first()
            ->avg_days ?? 0;

        // Top complainants
        $topComplainants = User::withCount('complaints')
            ->where('role', 'citizen')
            ->orderBy('complaints_count', 'desc')
            ->take(10)
            ->get();

        // Recent activity (last 30 days)
        $recentActivity = [
            'submitted' => Complaint::where('created_at', '>=', now()->subDays(30))->count(),
            'resolved' => Complaint::where('resolved_at', '>=', now()->subDays(30))->count(),
            'in_progress' => Complaint::where('status', 'in_progress')
                ->where('updated_at', '>=', now()->subDays(30))
                ->count(),
        ];

        return view('captain.analytics', compact(
            'monthlyTrends',
            'statusBreakdown',
            'categoryPerformance',
            'avgResolutionTime',
            'topComplainants',
            'recentActivity'
        ));
    }

    /**
     * Display reports page
     */
    public function reports()
    {
        $monthlyData = Complaint::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->take(6)
            ->get();

        $statusData = Complaint::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        $categoryData = Complaint::selectRaw('complaint_category_id, count(*) as count')
            ->groupBy('complaint_category_id')
            ->with('category')
            ->get();

        return view('captain.reports', compact('monthlyData', 'statusData', 'categoryData'));
    }

    /**
     * Export report as PDF
     */
    public function exportReport(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth());
        $endDate = $request->input('end_date', now());

        $complaints = Complaint::with(['user', 'category'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $stats = [
            'total' => $complaints->count(),
            'resolved' => $complaints->where('status', 'resolved')->count(),
            'pending' => $complaints->where('status', 'pending')->count(),
            'rejected' => $complaints->where('status', 'rejected')->count(),
        ];

        $pdf = Pdf::loadView('captain.reports-pdf', compact('complaints', 'stats', 'startDate', 'endDate'));
        
        return $pdf->download('barangay-complaints-report-' . now()->format('Y-m-d') . '.pdf');
    }
}
