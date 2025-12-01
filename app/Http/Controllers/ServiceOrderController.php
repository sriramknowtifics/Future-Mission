<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServiceOrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        $service = Service::findOrFail($request->service_id);

        // PRICE CALCULATION  
        $basePrice   = $service->offer_price > 0 ? $service->offer_price : $service->price;
        $visitFee    = $service->visit_fee ?? 0;
        $discount    = 0; // modify later if needed
        $taxAmount   = 0; // modify later for VAT
        $totalAmount = $basePrice + $visitFee - $discount + $taxAmount;

        $order = ServiceOrder::create([
            'user_id'           => auth()->id(),
            'service_id'        => $service->id,
            'vendor_id'         => $service->vendor_id,

            // REQUIRED FIELDS BY TABLE
            'base_price'        => $basePrice,
            'discount'          => $discount,
            'tax_amount'        => $taxAmount,
            'total_amount'      => $totalAmount,

            // BOOKING INFO
            'booking_date'      => now()->toDateString(),
            'booking_time'      => now()->format('H:i'),
            'duration_minutes'  => $service->duration_minutes,

            // STATUS
            'service_status'    => 'pending',
            'payment_status'    => 'awaiting_payment',
        ]);

        return redirect()->route('account.dashboard')
                        ->with('success', 'Service booked successfully!');
    }



    public function confirm(Request $request)
    {
        $ids = $request->selected ?? [];

        if (count($ids) == 0) {
            return back()->with('error', 'Select at least one booking.');
        }

        ServiceOrder::whereIn('id', $ids)
            ->update(['service_status' => 'accepted']);

        return redirect()->route('service.index')
                         ->with('success','Booking confirmed!');
    }
    public function show(ServiceOrder $order)
    {
        // Log::info($order);
      
        // Load relationships we need. loadMissing avoids re-loading if already loaded.
        $order->loadMissing(['service.images', 'vendor']);

        // DEBUG: quickly check whether service has images (temporary - remove for production)
        // \Log::debug('Service images count for service_id='.$order->service_id, [
        //     'count' => $order->service->images->count(),
        //     'images' => $order->service->images->pluck('id','path')->toArray()
        // ]);

        // Build a main image url (fall back to service thumbnail accessor or generic placeholder)
        $mainImageUrl = null;
        if ($order->service && $order->service->images && $order->service->images->count() > 0) {
            $first = $order->service->images->first();
            // If your image record uses 'path' column:
            if (!empty($first->path)) {
                $mainImageUrl = asset('storage/' . ltrim($first->path, '/'));
            } elseif (!empty($first->url)) { // in case your images store full url
                $mainImageUrl = $first->url;
            }
        }

        // Fallback to Service->thumbnail_url accessor if present on Service
        if (empty($mainImageUrl) && $order->service && isset($order->service->thumbnail_url)) {
            $mainImageUrl = $order->service->thumbnail_url;
        }

        // Final fallback
        if (empty($mainImageUrl)) {
            $mainImageUrl = asset('assets/images/placeholder.png');
        }

        return view('service.orders.show', [
            'order' => $order,
            'mainImageUrl' => $mainImageUrl,
        ]);
    }
    public function destroy(ServiceOrder $order)
    {
        // Authorization: Only owner can delete the booking
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Only pending bookings can be deleted/cancelled
        if ($order->service_status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be cancelled.');
        }

        // Perform soft delete
        $order->delete();

        

        return redirect()
            ->route('account.dashboard')
            ->with('success', 'Booking cancelled successfully.');
    }



}

