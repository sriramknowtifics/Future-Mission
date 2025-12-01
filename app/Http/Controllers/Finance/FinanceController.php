<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:finance']);
    }

    public function index(Request $request)
    {
        $transactions = Transaction::with('vendor')->orderByDesc('created_at')->paginate(30);
        return view('finance.index', compact('transactions'));
    }

    public function viewVendorSettlements(Vendor $vendor)
    {
        $transactions = $vendor->transactions()->orderByDesc('created_at')->paginate(30);
        return view('finance.vendor_settlements', compact('vendor','transactions'));
    }

    /**
     * Approve a settlement (mark transaction as completed).
     */
    public function approveSettlement(Request $request, Transaction $transaction)
    {
        $request->validate(['note' => 'nullable|string']);
        if ($transaction->status !== 'pending') {
            return back()->withErrors(['error' => 'Transaction is not pending.']);
        }

        DB::beginTransaction();
        try {
            // call external payout provider here or mark paid
            $transaction->status = 'completed';
            $transaction->meta = array_merge($transaction->meta ?? [], ['approved_by' => auth()->id(), 'note' => $request->input('note')]);
            $transaction->save();
            DB::commit();
            return back()->with('success','Transaction approved.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed: '.$e->getMessage()]);
        }
    }
}
