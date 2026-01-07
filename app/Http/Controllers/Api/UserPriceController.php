<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class UserPriceController extends Controller
{
    public function updatePrices(Request $request, User $user)
    {
        $validated = $request->validate([
            'marketing_price' => 'required|numeric|min:0',
            'utility_price'   => 'required|numeric|min:0',
            'auth_price'      => 'required|numeric|min:0',
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'Prices updated successfully ✅',
            'user'    => $user->only(['id', 'marketing_price', 'utility_price', 'auth_price']),
        ]);
    }

    public function getPrices(User $user)
    {
        return response()->json([
            'marketing_price' => $user->marketing_price,
            'utility_price'   => $user->utility_price,
            'auth_price'      => $user->auth_price,
        ]);
    }
}
