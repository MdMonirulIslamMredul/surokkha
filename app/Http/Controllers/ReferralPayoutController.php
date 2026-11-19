<?php

namespace App\Http\Controllers;

use App\Models\ReferralPayout;
use App\Models\Referrer;
use Carbon\Carbon;
use Exception;
use Flash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReferralPayoutController extends AppBaseController
{
    public function index(Request $request)
    {
        $query = ReferralPayout::with(['referrer.user', 'paidBy'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('referrer_id')) {
            $query->where('referrer_id', $request->referrer_id);
        }

        $payouts = $query->paginate(15);

        return view('referral_payouts.index', compact('payouts'));
    }

    public function create(Request $request)
    {
        $referrers = Referrer::with('user')->where('status', true)->get()->mapWithKeys(function ($r) {
            $name = $r->user->full_name ?? 'N/A';
            $code = $r->refer_code;
            $bal = number_format($r->balance, 2);
            return [$r->id => "{$name} ({$code}) - Available: " . getCurrencySymbol() . " {$bal}"];
        });

        $selectedReferrerId = $request->referrer_id ?? null;

        return view('referral_payouts.create', compact('referrers', 'selectedReferrerId'));
    }

    public function store(Request $request)
    {
        $request->validate(ReferralPayout::$rules);

        try {
            DB::beginTransaction();

            $referrer = Referrer::findOrFail($request->referrer_id);
            $amount = (float) $request->amount;

            if ($amount > $referrer->balance) {
                Flash::error("Payout amount (" . getCurrencySymbol() . " {$amount}) cannot exceed referrer's available balance (" . getCurrencySymbol() . " {$referrer->balance}).");
                return redirect()->back()->withInput();
            }

            $payout = ReferralPayout::create([
                'payout_number' => ReferralPayout::generatePayoutNumber(),
                'referrer_id' => $referrer->id,
                'amount' => $amount,
                'payment_method' => $request->payment_method ?? 'Cash',
                'reference_note' => $request->reference_note,
                'paid_by' => Auth::id(),
                'paid_at' => Carbon::now(),
            ]);

            DB::commit();

            Flash::success("Payout of " . getCurrencySymbol() . " {$amount} successfully recorded for {$referrer->user->full_name} ({$referrer->refer_code}). Payout #: {$payout->payout_number}");

            return redirect()->route('referral-payouts.index');
        } catch (Exception $e) {
            DB::rollBack();
            Flash::error('Error recording payout: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function getBalance($id): JsonResponse
    {
        $referrer = Referrer::with('user')->find($id);

        if (! $referrer) {
            return response()->json(['success' => false, 'message' => 'Referrer not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $referrer->id,
                'name' => $referrer->user->full_name ?? '',
                'code' => $referrer->refer_code,
                'total_earnings' => $referrer->total_earnings,
                'total_paid' => $referrer->total_paid,
                'balance' => $referrer->balance,
            ],
        ]);
    }
}

