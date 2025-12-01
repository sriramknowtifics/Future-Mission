<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ServiceApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }


    /* ============================================================
       LIST PENDING SERVICES
    ============================================================ */
    public function index(Request $request)
    {
        $services = Service::where('approval_status', 'pending')
            ->with(['vendor', 'category'])
            ->orderByDesc('created_at')
            ->paginate(25);

        return view('admin.services.pending', compact('services'));
    }


    /* ============================================================
       APPROVE SERVICE
    ============================================================ */
    public function approve(Service $service)
    {
        if ($service->approval_status === 'approved') {
            return back()->with('info', 'Service is already approved.');
        }

        $service->update([
            'approval_status' => 'approved',
            'approved_by'     => Auth::id(),
            'approved_at'     => now(),
        ]);

        Log::info("Service approved", [
            'service_id' => $service->id,
            'admin_id'   => Auth::id(),
        ]);

        // TODO: Send notification to vendor
        return back()->with('success', 'Service approved successfully.');
    }


    /* ============================================================
       REJECT SERVICE
    ============================================================ */
    public function reject(Request $request, Service $service)
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $service->update([
            'approval_status' => 'rejected',
            'approved_by'     => Auth::id(),
            'approved_at'     => now(),
            'rejection_reason' => $validated['reason'] ?? null,  // NEW FIELD
        ]);

        Log::warning("Service rejected", [
            'service_id' => $service->id,
            'admin_id'   => Auth::id(),
            'reason'     => $validated['reason'] ?? 'No reason provided',
        ]);

        // TODO: Notify vendor (mail or dashboard alert)
        return back()->with('success', 'Service rejected.');
    }


    /* ============================================================
       LIST ALL SERVICES
    ============================================================ */
    public function indexAll(Request $request)
    {
        $services = Service::with(['vendor', 'category'])
            ->orderByDesc('created_at')
            ->paginate(30);

        return view('admin.services.index', compact('services'));
    }
}
