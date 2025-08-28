<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->payments();

        if ($request->has('year')) {
            $query->whereYear('created_at', $request->year);
        }
        if ($request->has('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        return $query->latest()->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'category' => 'required|string|max:255',
            'attachment' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Auth::user();
        $paymentAmount = $request->amount;

        // Check if the user has sufficient balance
        if ($user->balance < $paymentAmount) {
            return response()->json(['message' => 'Insufficient balance.'], 422); // 422 Unprocessable Entity is a good status code here
        }


        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
        }

        $payment = Auth::user()->payments()->create([
            'description' => $request->description,
            'amount' => $request->amount,
            'category' => $request->category,
            'attachment_path' => $path,
            'status' => 'completed',
        ]);
        if ($payment) {
            $user->balance -= $paymentAmount;
            $user->save();
        }
        return response()->json($payment, 201);
    }

    public function show(Payment $payment)
    {
        // This policy ensures a user can only see their own payments.
        if ($payment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $payment;
    }
}
