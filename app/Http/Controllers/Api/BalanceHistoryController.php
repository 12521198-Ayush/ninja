<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\BalanceHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BalanceHistoryController extends Controller
{
    // Show balance history of a user
    public function index($userId)
    {
        $user = User::findOrFail($userId);
        $history = BalanceHistory::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'user' => $user,
            'balance_history' => $history,
        ]);
    }

    // Increment balance and log history
    public function incrementBalance(Request $request, $userId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string|max:255'
        ]);

        $user = User::findOrFail($userId);

        // update balance
        $user->balance += $request->amount;
        $user->save();

        // log history
        BalanceHistory::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'balance_after' => $user->balance,
            'type' => 'credit',
            'note' => $request->note ?? 'Balance incremented',
        ]);

        return response()->json([
            'message' => 'Balance incremented successfully',
            'user' => $user,
        ]);
    }
}
