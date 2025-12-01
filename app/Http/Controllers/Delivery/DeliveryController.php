<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\DeliveryAssignment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:delivery']);
    }

    /**
     * Delivery partner dashboard: list assigned orders
     */
    public function index()
    {
        $user = Auth::user();
        $assignments = DeliveryAssignment::where('delivery_user_id', $user->id)->with('order')->orderByDesc('created_at')->paginate(20);
        return view('delivery.index', compact('assignments'));
    }

    /**
     * Accept or reject job
     */
    public function accept(Request $request, DeliveryAssignment $assignment)
    {
        $user = Auth::user();
        if ($assignment->delivery_user_id !== $user->id) abort(403);

        $assignment->status = 'accepted';
        $assignment->save();

        // TODO: notify buyer/vendor
        return back()->with('success','Delivery accepted.');
    }

    public function updateStatus(Request $request, DeliveryAssignment $assignment)
    {
        $user = Auth::user();
        if ($assignment->delivery_user_id !== $user->id) abort(403);

        $request->validate(['status' => 'required|in:accepted,picked,out_for_delivery,delivered,failed', 'notes' => 'nullable|string']);

        $assignment->status = $request->input('status');

        if ($assignment->status === 'picked') {
            $assignment->picked_at = now();
        }

        if ($assignment->status === 'delivered') {
            $assignment->delivered_at = now();
            // update order
            $order = $assignment->order;
            $order->status = 'delivered';
            $order->save();
        }

        $assignment->notes = $request->input('notes', $assignment->notes);
        $assignment->save();

        return back()->with('success','Status updated.');
    }
}
