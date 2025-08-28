<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        // 1. Available balance (fictional)
        $available_balance = $user->balance;

        // 2. Regular payments (last completed payment of each category)
        $regular_payments = $user->payments()
            ->where('status', 'completed')
            ->select('category', DB::raw('MAX(amount) as last_amount'))
            ->groupBy('category')
            ->get();

        // 3. Recent payment history
        $recent_payments = $user->payments()->latest()->take(5)->get()->map(function ($payment) {
            return [
                'id' => $payment->id,
                'description' => $payment->description,
                'amount' => $payment->amount,
                'category' => $payment->category,
                'status' => $payment->status,
                'date' => $payment->created_at->toDateString(),
            ];
        });

        return response()->json([
            'available_balance' => $available_balance,
            'regular_payments' => $regular_payments,
            'recent_payments' => $recent_payments,
        ]);
    }
}
