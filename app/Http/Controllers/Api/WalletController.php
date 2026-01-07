<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BalanceHistory;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    public function incrementBalance(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $user = User::findOrFail($id);

        $user->wallet_balance += $request->amount;
        $user->save();

        BalanceHistory::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'balance_after' => $user->wallet_balance,
            'type' => 'credit',
            'note' => $request->note ?? 'Balance Credited',
        ]);

        return response()->json([
            'message' => 'Balance incremented successfully',
            'user' => $user
        ]);
    }

    public function decrementBalance(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $user = User::findOrFail($id);

        if ($user->wallet_balance < $request->amount) {
            return response()->json([
                'message' => 'Insufficient balance'
            ], 400);
        }

        $user->wallet_balance -= $request->amount;
        $user->save();

        BalanceHistory::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'balance_after' => $user->wallet_balance,
            'type' => 'debit',
            'note' => $request->note ?? 'Balance Debited',
        ]);

        return response()->json([
            'message' => 'Balance debited successfully',
            'user' => $user
        ]);
    }

    public function getBalance($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'balance' => $user->wallet_balance,
        ]);
    }
}
