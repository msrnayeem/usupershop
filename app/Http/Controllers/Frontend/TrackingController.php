<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * Track order by ID (from dashboard link).
     * Works for both logged-in users and guests (via invoice_no fallback).
     */
    public function orderTrackNow(Request $request, $id = null)
    {
        if (!$id) {
            return redirect()->route('order.track');
        }

        // Build query - if logged in, verify ownership; if guest, allow by ID
        $query = Order::with(['users', 'shipping'])->where('id', $id);

        if (auth()->check()) {
            $query->where('user_id', auth()->user()->id);
        }

        $order = $query->first();

        if ($order) {
            $orderItems = OrderDetail::with('product')
                ->where('order_id', $order->id)
                ->orderBy('id', 'DESC')
                ->get();
            return view('frontend.order-track', compact('order', 'orderItems'));
        }

        return redirect()->back()->with('error', 'Order not found.');
    }

    /**
     * Track by invoice number (USP00044 format) — public, no login needed.
     */
    public function orderTrackSubmit(Request $request)
    {
        $request->validate([
            'invoice_no' => 'required|string|min:3|max:30',
        ]);

        $invoice_no = strtoupper(trim($request->invoice_no));

        // Support both "USP44" and "USP00044" formats — normalize to lookup
        $order = Order::with(['users', 'shipping'])
            ->where('invoice_no', $invoice_no)
            ->orWhere(function($q) use ($invoice_no) {
                // Try zero-padded version if user typed without zeros (e.g. USP44)
                if (preg_match('/^USP(\\d+)$/', $invoice_no, $m)) {
                    $padded = 'USP' . str_pad((int)$m[1], 5, '0', STR_PAD_LEFT);
                    $q->where('invoice_no', $padded);
                }
            })
            ->first();

        if ($order) {
            $orderItems = OrderDetail::with('product')
                ->where('order_id', $order->id)
                ->orderBy('id', 'DESC')
                ->get();
            return view('frontend.order-track', compact('order', 'orderItems'));
        }

        return redirect()->back()->with('error', 'Order not found. Please check the invoice number (e.g. USP00044).');
    }
}
