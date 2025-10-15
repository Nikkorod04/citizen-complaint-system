<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Services\QRCodeService;

class CitizenController extends Controller
{
    protected $qrCodeService;

    public function __construct(QRCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    /**
     * Display the citizen dashboard
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        $complaints = Complaint::where('user_id', $user->id)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total' => Complaint::where('user_id', $user->id)->count(),
            'pending' => Complaint::where('user_id', $user->id)->where('status', 'pending')->count(),
            'validated' => Complaint::where('user_id', $user->id)->where('status', 'validated')->count(),
            'resolved' => Complaint::where('user_id', $user->id)->where('status', 'resolved')->count(),
        ];

        return view('citizen.dashboard', compact('complaints', 'stats'));
    }

    /**
     * Display all complaints for the citizen
     */
    public function complaints()
    {
        $complaints = Complaint::where('user_id', auth()->id())
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('citizen.complaints', compact('complaints'));
    }

    /**
     * Display the citizen's QR code
     */
    public function qrCode()
    {
        $user = auth()->user();
        $qrCodeUrl = $user->qr_code ? $this->qrCodeService->getQRCodeUrl($user->qr_code) : null;

        return view('citizen.qr-code', compact('user', 'qrCodeUrl'));
    }
}
